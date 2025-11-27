<?php
class EmployerController extends Controller {
    private $employerModel;
    private $jobModel;
    private $applicationModel;
    private $notificationModel;
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->employerModel = new Employer();
        $this->jobModel = new Job();
        $this->applicationModel = new Application();
        $this->notificationModel = new Notification();
        $this->userModel = new User();
    }
    
    // Dashboard nhà tuyển dụng
    public function dashboard() {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        if (!$employer) {
            setFlash('error', 'Không tìm thấy thông tin nhà tuyển dụng');
            $this->redirect('/logout');
            return;
        }
        
        // Lấy thống kê
        $stats = $this->employerModel->getStats($employer['ID_NhaTuyenDung']);
        
        // Lấy bài đăng mới nhất
        $latestJobs = $this->jobModel->getByEmployer($employer['ID_NhaTuyenDung'], 5, 0);
        
        // Lấy đơn ứng tuyển mới
        $newApplications = $this->applicationModel->getByEmployer($employer['ID_NhaTuyenDung'], ['trang_thai' => 'Mới nộp'], 10, 0);
        
        $this->view('employer/dashboard', [
            'title' => 'Dashboard Nhà tuyển dụng',
            'employer' => $employer,
            'stats' => $stats,
            'latest_jobs' => $latestJobs,
            'new_applications' => $newApplications
        ]);
    }
    
    // Hiển thị form đăng tin
    public function showPostJob() {
        Middleware::employer();
        
        $this->view('employer/post-job', [
            'title' => 'Đăng tin tuyển dụng'
        ]);
    }
    
    // Xử lý đăng tin
    public function postJob() {
        Middleware::employer();
        
        if (!isPost()) {
            $this->redirect('/employer/jobs/create');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        // Validation
        $validator = validate($_POST, [
            'tieu_de' => 'required|min:10',
            'mo_ta' => 'required|min:50',
            'yeu_cau' => 'required|min:30',
            'dia_diem' => 'required'
        ]);
        
        if (!$validator->validate($_POST)) {
            setFlash('errors', $validator->getErrors());
            setFlash('old', $_POST);
            $this->redirect('/employer/jobs/create');
            return;
        }
        
        $data = [
            'tieu_de' => input('tieu_de'),
            'mo_ta' => input('mo_ta'),
            'yeu_cau' => input('yeu_cau'),
            'muc_luong' => input('muc_luong'),
            'muc_luong_max' => input('muc_luong_max'),
            'loai_luong' => input('loai_luong', 'Thỏa thuận'),
            'dia_diem' => input('dia_diem'),
            'loai_cong_viec' => input('loai_cong_viec', 'Full-time'),
            'cap_bac' => input('cap_bac'),
            'kinh_nghiem' => input('kinh_nghiem'),
            'so_luong' => input('so_luong', 1),
            'ngay_het_han' => input('ngay_het_han')
        ];
        
        $jobId = $this->jobModel->create($employer['ID_NhaTuyenDung'], $data);
        
        if ($jobId) {
            setFlash('success', 'Đăng tin tuyển dụng thành công!');
            $this->redirect('/employer/jobs');
        } else {
            setFlash('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            $this->redirect('/employer/jobs/create');
        }
    }
    
    // Quản lý bài đăng
    public function manageJobs() {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        $page = input('page', 1);
        $jobs = $this->jobModel->getByEmployer($employer['ID_NhaTuyenDung'], 20, ($page - 1) * 20);
        
        $this->view('employer/manage-jobs', [
            'title' => 'Quản lý tin tuyển dụng',
            'jobs' => $jobs,
            'employer' => $employer
        ]);
    }
    
    // Hiển thị form sửa tin
    public function showEditJob($id) {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        $job = $this->jobModel->findById($id);
        
        // Kiểm tra quyền sở hữu
        if (!$job || $job['ID_NhaTuyenDung'] !== $employer['ID_NhaTuyenDung']) {
            setFlash('error', 'Bạn không có quyền chỉnh sửa bài đăng này');
            $this->redirect('/employer/jobs');
            return;
        }
        
        $this->view('employer/edit-job', [
            'title' => 'Chỉnh sửa tin tuyển dụng',
            'job' => $job
        ]);
    }
    
    // Xử lý cập nhật tin
    public function updateJob($id) {
        Middleware::employer();
        
        if (!isPost()) {
            $this->redirect('/employer/jobs');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        $job = $this->jobModel->findById($id);
        
        // Kiểm tra quyền sở hữu
        if (!$job || $job['ID_NhaTuyenDung'] !== $employer['ID_NhaTuyenDung']) {
            setFlash('error', 'Bạn không có quyền chỉnh sửa bài đăng này');
            $this->redirect('/employer/jobs');
            return;
        }
        
        $data = [
            'tieu_de' => input('tieu_de'),
            'mo_ta' => input('mo_ta'),
            'yeu_cau' => input('yeu_cau'),
            'muc_luong' => input('muc_luong'),
            'muc_luong_max' => input('muc_luong_max'),
            'loai_luong' => input('loai_luong'),
            'dia_diem' => input('dia_diem'),
            'loai_cong_viec' => input('loai_cong_viec'),
            'cap_bac' => input('cap_bac'),
            'kinh_nghiem' => input('kinh_nghiem'),
            'so_luong' => input('so_luong'),
            'ngay_het_han' => input('ngay_het_han')
        ];
        
        if ($this->jobModel->update($id, $data)) {
            setFlash('success', 'Cập nhật tin tuyển dụng thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/employer/jobs');
    }
    
    // Xóa tin
    public function deleteJob($id) {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        $job = $this->jobModel->findById($id);
        
        // Kiểm tra quyền sở hữu
        if (!$job || $job['ID_NhaTuyenDung'] !== $employer['ID_NhaTuyenDung']) {
            setFlash('error', 'Bạn không có quyền xóa bài đăng này');
            $this->redirect('/employer/jobs');
            return;
        }
        
        if ($this->jobModel->delete($id)) {
            setFlash('success', 'Xóa tin tuyển dụng thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/employer/jobs');
    }
    
    // Quản lý ứng viên
    public function manageApplications() {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        $filters = [
            'trang_thai' => input('trang_thai'),
            'job_id' => input('job_id')
        ];
        
        $page = input('page', 1);
        $applications = $this->applicationModel->getByEmployer($employer['ID_NhaTuyenDung'], $filters, 20, ($page - 1) * 20);
        
        // Lấy danh sách jobs để filter
        $jobs = $this->jobModel->getByEmployer($employer['ID_NhaTuyenDung'], 100, 0);
        
        $this->view('employer/manage-applications', [
            'title' => 'Quản lý ứng viên',
            'employer' => $employer,
            'applications' => $applications,
            'jobs' => $jobs,
            'filters' => $filters
        ]);
    }
    
    // Chi tiết đơn ứng tuyển
    public function applicationDetail($id) {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        $application = $this->applicationModel->findById($id);
        
        // Kiểm tra quyền
        if (!$application || $application['ID_NhaTuyenDung'] !== $employer['ID_NhaTuyenDung']) {
            setFlash('error', 'Bạn không có quyền xem đơn ứng tuyển này');
            $this->redirect('/employer/applications');
            return;
        }
        
        $this->view('employer/application-detail', [
            'title' => 'Chi tiết đơn ứng tuyển',
            'application' => $application
        ]);
    }
    
    // Cập nhật trạng thái đơn ứng tuyển
    public function updateApplicationStatus($id) {
        Middleware::employer();
        
        if (!isPost()) {
            $this->redirect('/employer/applications');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        $application = $this->applicationModel->findById($id);
        
        // Kiểm tra quyền
        if (!$application) {
            setFlash('error', 'Đơn ứng tuyển không tồn tại');
            $this->redirect('/employer/applications');
            return;
        }
        
        $status = input('status');
        $message = input('message');
        
        if ($this->applicationModel->updateStatus($id, $status)) {
            // Tạo thông báo kết hợp
            $statusMessages = [
                'Đã xem' => 'Nhà tuyển dụng đã xem hồ sơ của bạn',
                'Mời phỏng vấn' => 'Chúc mừng! Bạn đã được mời phỏng vấn',
                'Từ chối' => 'Rất tiếc, hồ sơ của bạn chưa phù hợp lần này',
                'Trúng tuyển' => 'Chúc mừng! Bạn đã trúng tuyển'
            ];
            
            $title = $statusMessages[$status] ?? 'Cập nhật trạng thái đơn ứng tuyển';
            $content = "Đơn ứng tuyển của bạn cho vị trí \"{$application['TieuDe']}\" đã được cập nhật: {$status}";
            
            // Thêm thông báo tùy chỉnh nếu có
            if (!empty($message)) {
                $content .= "\n\n📝 Thông báo từ nhà tuyển dụng:\n" . $message;
            }
            
            $this->notificationModel->create($application['ID_UngVien'], [
                'don_ung_tuyen_id' => $id,
                'tieu_de' => $title,
                'noi_dung' => $content,
                'loai' => 'Ứng tuyển'
            ]);
            
            setFlash('success', 'Cập nhật trạng thái thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->back();
    }
    
    // Xóa đơn ứng tuyển
    public function deleteApplication($id) {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        $application = $this->applicationModel->findById($id);
        
        // Kiểm tra quyền
        if (!$application || $application['ID_NhaTuyenDung'] !== $employer['ID_NhaTuyenDung']) {
            setFlash('error', 'Bạn không có quyền xóa đơn này');
            $this->redirect('/employer/applications');
            return;
        }
        
        if ($this->applicationModel->delete($id)) {
            setFlash('success', 'Đã xóa đơn ứng tuyển');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/employer/applications');
    }
    
    // Quản lý thông tin công ty
    public function profile() {
        Middleware::employer();
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        $this->view('employer/profile', [
            'title' => 'Thông tin công ty',
            'employer' => $employer
        ]);
    }
    
    // Cập nhật thông tin công ty
    public function updateProfile() {
        Middleware::employer();
        
        if (!isPost()) {
            $this->redirect('/employer/profile');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        $data = [
            'ten' => input('ten'),
            'mo_ta' => input('mo_ta'),
            'trang_web' => input('trang_web'),
            'dia_chi' => input('dia_chi'),
            'sdt' => input('sdt'),
            'email' => input('email'),
            'quy_mo' => input('quy_mo'),
            'linh_vuc' => input('linh_vuc'),
            'logo' => $employer['Logo'] // Giữ nguyên logo cũ, upload sẽ làm sau
        ];
        
        if ($this->employerModel->update($employer['ID_NhaTuyenDung'], $data)) {
            setFlash('success', 'Cập nhật thông tin thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/employer/profile');
    }
    
    // Đổi mật khẩu
    public function changePassword() {
        Middleware::employer();
        
        if (!isPost()) {
            $this->redirect('/employer/profile');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $oldPassword = input('old_password');
        $newPassword = input('new_password');
        $confirmPassword = input('confirm_password');
        
        if ($newPassword !== $confirmPassword) {
            setFlash('error', 'Mật khẩu xác nhận không khớp');
            $this->redirect('/employer/profile');
            return;
        }
        
        if ($this->userModel->changePassword($currentUser['id'], $oldPassword, $newPassword)) {
            setFlash('success', 'Đổi mật khẩu thành công');
        } else {
            setFlash('error', 'Mật khẩu cũ không đúng');
        }
        
        $this->redirect('/employer/profile');
    }
    
    // Upload logo
    public function uploadLogo() {
        if (!$this->isLoggedIn() || !isPost()) {
            $this->redirect('/employer/profile');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $employer = $this->employerModel->findByUserId($currentUser['id']);
        
        if (!$employer) {
            setFlash('error', 'Không tìm thấy thông tin nhà tuyển dụng');
            $this->redirect('/employer/profile');
            return;
        }
        
        // Kiểm tra file upload
        if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            setFlash('error', 'Vui lòng chọn file logo');
            $this->redirect('/employer/profile');
            return;
        }
        
        $file = $_FILES['logo'];
        
        // Validate file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            setFlash('error', 'Chỉ chấp nhận file JPG, PNG hoặc GIF');
            $this->redirect('/employer/profile');
            return;
        }
        
        // Check file size (2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            setFlash('error', 'File không được vượt quá 2MB');
            $this->redirect('/employer/profile');
            return;
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'logo_' . $employer['ID_NhaTuyenDung'] . '_' . time() . '.' . $extension;
        $uploadPath = BASE_PATH . '/public/uploads/' . $filename;
        
        // Create uploads directory if not exists
        if (!file_exists(BASE_PATH . '/public/uploads')) {
            mkdir(BASE_PATH . '/public/uploads', 0777, true);
        }
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Delete old logo if exists
            if ($employer['Logo'] && file_exists(BASE_PATH . '/public/uploads/' . $employer['Logo'])) {
                unlink(BASE_PATH . '/public/uploads/' . $employer['Logo']);
            }
            
            // Update database - chỉ update logo
            $db = Database::getInstance();
            $sql = "UPDATE nhatuyendung SET Logo = ? WHERE ID_NhaTuyenDung = ?";
            
            if ($db->execute($sql, [$filename, $employer['ID_NhaTuyenDung']])) {
                setFlash('success', 'Upload logo thành công');
            } else {
                setFlash('error', 'Có lỗi khi cập nhật database');
            }
        } else {
            setFlash('error', 'Có lỗi khi upload file');
        }
        
        $this->redirect('/employer/profile');
    }
}
