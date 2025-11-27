<?php
class AuthController extends Controller {
    private $userModel;
    private $applicantModel;
    private $employerModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->applicantModel = new Applicant();
        $this->employerModel = new Employer();
    }
    
    // Hiển thị trang đăng ký
    public function showRegister() {
        Middleware::guest();
        $this->view('auth/register');
    }
    
    // Xử lý đăng ký
    public function register() {
        if (!isPost()) {
            $this->redirect('/register');
            return;
        }
        
        // Validation
        $validator = validate($_POST, [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required',
            'ho_ten' => 'required|min:2',
            'loai_tai_khoan' => 'required'
        ]);
        
        if (!$validator->validate($_POST)) {
            setFlash('errors', $validator->getErrors());
            setFlash('old', $_POST);
            $this->redirect('/register');
            return;
        }
        
        // Kiểm tra password confirmation
        if ($_POST['password'] !== $_POST['password_confirmation']) {
            setFlash('error', 'Mật khẩu xác nhận không khớp');
            setFlash('old', $_POST);
            $this->redirect('/register');
            return;
        }
        
        // Kiểm tra email đã tồn tại
        if ($this->userModel->findByEmail($_POST['email'])) {
            setFlash('error', 'Email đã được sử dụng');
            setFlash('old', $_POST);
            $this->redirect('/register');
            return;
        }
        
        try {
            $this->db->beginTransaction();
            
            // Tạo tài khoản
            $result = $this->userModel->create($_POST['email'], $_POST['password']);
            $userId = $result['id'];
            $token = $result['token'];
            
            // Gán vai trò
            $role = $_POST['loai_tai_khoan'] === 'employer' ? 'EMPLOYER' : 'APPLICANT';
            $this->userModel->assignRole($userId, $role);
            
            // Tạo profile
            $names = explode(' ', trim($_POST['ho_ten']));
            $ten = array_pop($names);
            $hoLot = implode(' ', $names);
            
            if ($role === 'APPLICANT') {
                $this->applicantModel->create($userId, [
                    'ho_lot' => $hoLot,
                    'ten' => $ten,
                    'email' => $_POST['email']
                ]);
            } else {
                $this->employerModel->create($userId, [
                    'ten' => $_POST['ho_ten'],
                    'email' => $_POST['email']
                ]);
            }
            
            $this->db->commit();
            
            // Gửi email xác thực
            sendVerificationEmail($_POST['email'], $token);
            
            setFlash('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
            $this->redirect('/login');
            
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            setFlash('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            $this->redirect('/register');
        }
    }
    
    // Hiển thị trang đăng nhập
    public function showLogin() {
        Middleware::guest();
        $this->view('auth/login');
    }
    
    // Xử lý đăng nhập
    public function login() {
        if (!isPost()) {
            $this->redirect('/login');
            return;
        }
        
        $email = input('email');
        $password = input('password');
        
        // Validation
        if (empty($email) || empty($password)) {
            setFlash('error', 'Vui lòng nhập đầy đủ thông tin');
            $this->redirect('/login');
            return;
        }
        
        // Tìm user
        $user = $this->userModel->findByEmail($email);
        
        if (!$user || !verifyPassword($password, $user['Pass'])) {
            setFlash('error', 'Email hoặc mật khẩu không đúng');
            $this->redirect('/login');
            return;
        }
        
        // Kiểm tra trạng thái
        if ($user['TrangThai'] !== 'active') {
            setFlash('error', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email.');
            $this->redirect('/login');
            return;
        }
        
        // Lấy vai trò
        $roles = $this->userModel->getRoles($user['ID_TaiKhoan']);
        $role = $roles[0] ?? 'APPLICANT';
        
        // Lưu session
        $_SESSION['user_id'] = $user['ID_TaiKhoan'];
        $_SESSION['user_email'] = $user['Email'];
        $_SESSION['user_role'] = $role;
        
        // Redirect theo vai trò
        switch ($role) {
            case 'ADMIN':
                $this->redirect('/admin/dashboard');
                break;
            case 'EMPLOYER':
                $this->redirect('/employer/dashboard');
                break;
            default:
                $this->redirect('/applicant/dashboard');
        }
    }
    
    // Đăng xuất
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
    
    // Xác thực email
    public function verifyEmail() {
        $token = input('token');
        
        if (empty($token)) {
            setFlash('error', 'Token không hợp lệ');
            $this->redirect('/login');
            return;
        }
        
        if ($this->userModel->verifyEmail($token)) {
            setFlash('success', 'Xác thực tài khoản thành công! Bạn có thể đăng nhập.');
        } else {
            setFlash('error', 'Token không hợp lệ hoặc đã hết hạn');
        }
        
        $this->redirect('/login');
    }
    
    // Hiển thị trang quên mật khẩu
    public function showForgotPassword() {
        Middleware::guest();
        $this->view('auth/forgot-password');
    }
    
    // Xử lý quên mật khẩu
    public function forgotPassword() {
        if (!isPost()) {
            $this->redirect('/forgot-password');
            return;
        }
        
        $email = input('email');
        
        if (empty($email)) {
            setFlash('error', 'Vui lòng nhập email');
            $this->redirect('/forgot-password');
            return;
        }
        
        $token = $this->userModel->createResetToken($email);
        
        if ($token) {
            sendResetPasswordEmail($email, $token);
            setFlash('success', 'Link đặt lại mật khẩu đã được gửi đến email của bạn');
        } else {
            setFlash('error', 'Email không tồn tại trong hệ thống');
        }
        
        $this->redirect('/forgot-password');
    }
    
    // Hiển thị trang reset mật khẩu
    public function showResetPassword() {
        $token = input('token');
        
        if (empty($token)) {
            setFlash('error', 'Token không hợp lệ');
            $this->redirect('/login');
            return;
        }
        
        $this->view('auth/reset-password', ['token' => $token]);
    }
    
    // Xử lý reset mật khẩu
    public function resetPassword() {
        if (!isPost()) {
            $this->redirect('/login');
            return;
        }
        
        $token = input('token');
        $password = input('password');
        $passwordConfirmation = input('password_confirmation');
        
        if (empty($token) || empty($password)) {
            setFlash('error', 'Vui lòng nhập đầy đủ thông tin');
            $this->redirect('/reset-password?token=' . $token);
            return;
        }
        
        if ($password !== $passwordConfirmation) {
            setFlash('error', 'Mật khẩu xác nhận không khớp');
            $this->redirect('/reset-password?token=' . $token);
            return;
        }
        
        if ($this->userModel->resetPassword($token, $password)) {
            setFlash('success', 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập.');
            $this->redirect('/login');
        } else {
            setFlash('error', 'Token không hợp lệ hoặc đã hết hạn');
            $this->redirect('/forgot-password');
        }
    }
}
