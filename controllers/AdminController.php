<?php
class AdminController extends Controller {
    private $userModel;
    private $jobModel;
    private $applicantModel;
    private $employerModel;
    private $adminLogModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->jobModel = new Job();
        $this->applicantModel = new Applicant();
        $this->employerModel = new Employer();
        $this->adminLogModel = new AdminLog();
    }
    
    // Dashboard admin
    public function dashboard() {
        Middleware::admin();
        
        // Lấy thống kê
        $stats = [
            'total_users' => $this->userModel->count(),
            'total_applicants' => $this->applicantModel->count(),
            'total_employers' => $this->employerModel->count(),
            'total_jobs' => $this->jobModel->count(),
        ];
        
        // Lấy bài đăng mới nhất
        $latestJobs = $this->jobModel->getLatest(5);
        
        // Lấy users mới nhất
        $latestUsers = $this->userModel->getAll(10, 0);
        
        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'latest_jobs' => $latestJobs,
            'latest_users' => $latestUsers
        ]);
    }
    
    // Quản lý users
    public function users() {
        Middleware::admin();
        
        $page = input('page', 1);
        $totalUsers = $this->userModel->count();
        $pagination = paginate($totalUsers, $page);
        
        $users = $this->userModel->getAll($pagination['items_per_page'], $pagination['offset']);
        
        $this->view('admin/users', [
            'title' => 'Quản lý người dùng',
            'users' => $users,
            'pagination' => $pagination
        ]);
    }
    
    // Chi tiết user
    public function userDetail($id) {
        Middleware::admin();
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            setFlash('error', 'Người dùng không tồn tại');
            $this->redirect('/admin/users');
            return;
        }
        
        $this->view('admin/user-detail', [
            'title' => 'Chi tiết người dùng',
            'user' => $user
        ]);
    }
    
    // Hiển thị form sửa user
    public function showEditUser($id) {
        Middleware::admin();
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            setFlash('error', 'Người dùng không tồn tại');
            $this->redirect('/admin/users');
            return;
        }
        
        $this->view('admin/user-edit', [
            'title' => 'Chỉnh sửa người dùng',
            'user' => $user
        ]);
    }
    
    // Xử lý cập nhật user
    public function updateUser($id) {
        Middleware::admin();
        
        if (!isPost()) {
            $this->redirect('/admin/users');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            setFlash('error', 'Người dùng không tồn tại');
            $this->redirect('/admin/users');
            return;
        }
        
        try {
            $this->db->beginTransaction();
            
            // Cập nhật email nếu thay đổi
            $newEmail = input('email');
            if ($newEmail !== $user['Email']) {
                // Kiểm tra email đã tồn tại chưa
                $existingUser = $this->userModel->findByEmail($newEmail);
                if ($existingUser && $existingUser['ID_TaiKhoan'] !== $id) {
                    setFlash('error', 'Email đã được sử dụng bởi tài khoản khác');
                    $this->redirect('/admin/users/' . $id . '/edit');
                    return;
                }
                
                // Update email
                $sql = "UPDATE TAIKHOAN SET Email = ? WHERE ID_TaiKhoan = ?";
                $this->db->execute($sql, [$newEmail, $id]);
            }
            
            // Cập nhật trạng thái
            $trangThai = input('trang_thai');
            $this->userModel->updateStatus($id, $trangThai);
            
            // Đặt lại mật khẩu nếu có
            $newPassword = input('new_password');
            if (!empty($newPassword)) {
                $hashedPassword = hashPassword($newPassword);
                $sql = "UPDATE TAIKHOAN SET Pass = ? WHERE ID_TaiKhoan = ?";
                $this->db->execute($sql, [$hashedPassword, $id]);
            }
            
            $this->db->commit();
            
            // Ghi log
            $ghiChu = input('ghi_chu', 'Admin cập nhật thông tin tài khoản');
            $info = "Email: $newEmail, Trạng thái: $trangThai";
            if (!empty($newPassword)) {
                $info .= ", Đã đặt lại mật khẩu";
            }
            $this->adminLogModel->logAccountAction($id, 'User', 'Cập nhật tài khoản', $currentUser['id'], $info . ". Ghi chú: $ghiChu");
            
            setFlash('success', 'Cập nhật người dùng thành công');
            $this->redirect('/admin/users');
            
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            setFlash('error', 'Có lỗi xảy ra: ' . $e->getMessage());
            $this->redirect('/admin/users/' . $id . '/edit');
        }
    }
    
    // Cập nhật trạng thái user
    public function updateUserStatus($id) {
        Middleware::admin();
        
        if (!isPost()) {
            $this->redirect('/admin/users');
            return;
        }
        
        $status = input('status');
        $currentUser = $this->getCurrentUser();
        
        if ($this->userModel->updateStatus($id, $status)) {
            // Ghi log
            $action = $status === 'locked' ? 'Khóa tài khoản' : 'Mở khóa tài khoản';
            $this->adminLogModel->logAccountAction($id, 'User', $action, $currentUser['id'], "Trạng thái: $status");
            
            setFlash('success', 'Cập nhật trạng thái thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/admin/users');
    }
    
    // Xóa user
    public function deleteUser($id) {
        Middleware::admin();
        
        $currentUser = $this->getCurrentUser();
        $user = $this->userModel->findById($id);
        
        if ($user) {
            // Ghi log TRƯỚC KHI xóa
            try {
                $this->adminLogModel->logAccountAction($id, 'User', 'Xóa tài khoản', $currentUser['id'], "Email: {$user['Email']}");
            } catch (Exception $e) {
                // Nếu không ghi được log, vẫn tiếp tục xóa
                error_log("Failed to log account deletion: " . $e->getMessage());
            }
            
            // Xóa user
            if ($this->userModel->delete($id)) {
                setFlash('success', 'Xóa người dùng thành công');
            } else {
                setFlash('error', 'Có lỗi xảy ra khi xóa');
            }
        } else {
            setFlash('error', 'Người dùng không tồn tại');
        }
        
        $this->redirect('/admin/users');
    }
    
    // Quản lý jobs
    public function jobs() {
        Middleware::admin();
        
        $page = input('page', 1);
        $totalJobs = $this->jobModel->count();
        $pagination = paginate($totalJobs, $page);
        
        $jobs = $this->jobModel->getAll($pagination['items_per_page'], $pagination['offset']);
        
        $this->view('admin/jobs', [
            'title' => 'Quản lý bài đăng',
            'jobs' => $jobs,
            'pagination' => $pagination
        ]);
    }
    
    // Hiển thị form sửa job
    public function showEditJob($id) {
        Middleware::admin();
        
        $job = $this->jobModel->findById($id);
        
        if (!$job) {
            setFlash('error', 'Bài đăng không tồn tại');
            $this->redirect('/admin/jobs');
            return;
        }
        
        $this->view('admin/job-edit', [
            'title' => 'Chỉnh sửa bài đăng',
            'job' => $job
        ]);
    }
    
    // Xử lý cập nhật job
    public function updateJob($id) {
        Middleware::admin();
        
        if (!isPost()) {
            $this->redirect('/admin/jobs');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $job = $this->jobModel->findById($id);
        
        if (!$job) {
            setFlash('error', 'Bài đăng không tồn tại');
            $this->redirect('/admin/jobs');
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
            // Cập nhật trạng thái nếu có
            $trangThai = input('trang_thai');
            if ($trangThai) {
                $this->jobModel->updateStatus($id, $trangThai);
            }
            
            // Ghi log
            $lyDo = input('ly_do', 'Admin chỉnh sửa bài đăng');
            $this->adminLogModel->logJobAction($id, $job['ID_NhaTuyenDung'], $currentUser['id'], 'Chỉnh sửa bài đăng', $lyDo);
            
            setFlash('success', 'Cập nhật bài đăng thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra khi cập nhật');
        }
        
        $this->redirect('/admin/jobs');
    }
    
    // Ẩn/hiện job
    public function toggleJobStatus($id) {
        Middleware::admin();
        
        if (!isPost()) {
            $this->redirect('/admin/jobs');
            return;
        }
        
        $status = input('status');
        $currentUser = $this->getCurrentUser();
        
        // Lấy thông tin job để ghi log
        $job = $this->jobModel->findById($id);
        
        if ($job && $this->jobModel->updateStatus($id, $status)) {
            // Ghi log
            $action = $status === 'hidden' ? 'Ẩn bài đăng' : 'Hiện bài đăng';
            $this->adminLogModel->logJobAction($id, $job['ID_NhaTuyenDung'], $currentUser['id'], $action, "Trạng thái: $status");
            
            setFlash('success', 'Cập nhật trạng thái thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/admin/jobs');
    }
    
    // Xóa job
    public function deleteJob($id) {
        Middleware::admin();
        
        $currentUser = $this->getCurrentUser();
        $job = $this->jobModel->findById($id);
        
        if ($job) {
            // Ghi log TRƯỚC KHI xóa
            try {
                $this->adminLogModel->logJobAction($id, $job['ID_NhaTuyenDung'], $currentUser['id'], 'Xóa bài đăng', "Tiêu đề: {$job['TieuDe']}");
            } catch (Exception $e) {
                // Nếu không ghi được log, vẫn tiếp tục xóa
                error_log("Failed to log job deletion: " . $e->getMessage());
            }
            
            // Xóa job
            if ($this->jobModel->delete($id)) {
                setFlash('success', 'Xóa bài đăng thành công');
            } else {
                setFlash('error', 'Có lỗi xảy ra khi xóa');
            }
        } else {
            setFlash('error', 'Bài đăng không tồn tại');
        }
        
        $this->redirect('/admin/jobs');
    }
    
    // Thay đổi vai trò user
    public function changeUserRole($userId) {
        Middleware::admin();
        
        if (!isPost()) {
            $this->redirect('/admin/users/' . $userId);
            return;
        }
        
        $newRole = input('new_role');
        
        if (!in_array($newRole, ['APPLICANT', 'EMPLOYER'])) {
            setFlash('error', 'Vai trò không hợp lệ');
            $this->redirect('/admin/users/' . $userId);
            return;
        }
        
        $db = Database::getInstance();
        
        try {
            $db->beginTransaction();
            
            // Lấy thông tin user hiện tại
            $user = $this->userModel->findById($userId);
            if (!$user) {
                throw new Exception('Không tìm thấy user');
            }
            
            // Lấy vai trò hiện tại
            $currentRoles = $this->userModel->getUserRoles($userId);
            $currentRole = $currentRoles[0] ?? null;
            
            if ($currentRole === $newRole) {
                setFlash('info', 'User đã có vai trò này rồi');
                $db->rollback();
                $this->redirect('/admin/users/' . $userId);
                return;
            }
            
            // Xóa vai trò cũ
            if ($currentRole) {
                $roleId = $this->userModel->getRoleIdByName($currentRole);
                $db->execute(
                    "DELETE FROM taikhoanvaitro WHERE ID_TaiKhoan = ? AND ID_VaiTro = ?",
                    [$userId, $roleId]
                );
            }
            
            // Thêm vai trò mới
            $newRoleId = $this->userModel->getRoleIdByName($newRole);
            $db->execute(
                "INSERT INTO taikhoanvaitro (ID_TaiKhoan, ID_VaiTro) VALUES (?, ?)",
                [$userId, $newRoleId]
            );
            
            // Nếu chuyển sang EMPLOYER, tạo record trong bảng nhatuyendung
            if ($newRole === 'EMPLOYER') {
                // Kiểm tra xem đã có record chưa
                $employer = $db->fetchOne(
                    "SELECT * FROM nhatuyendung WHERE ID_TaiKhoan = ?",
                    [$userId]
                );
                
                if (!$employer) {
                    $employerId = generateId('NTD');
                    $db->execute(
                        "INSERT INTO nhatuyendung (ID_NhaTuyenDung, ID_TaiKhoan, Ten) VALUES (?, ?, ?)",
                        [$employerId, $userId, 'Chưa cập nhật']
                    );
                }
            }
            
            // Nếu chuyển sang APPLICANT, tạo record trong bảng ungvien
            if ($newRole === 'APPLICANT') {
                // Kiểm tra xem đã có record chưa
                $applicant = $db->fetchOne(
                    "SELECT * FROM ungvien WHERE ID_TaiKhoan = ?",
                    [$userId]
                );
                
                if (!$applicant) {
                    $applicantId = generateId('UV');
                    $db->execute(
                        "INSERT INTO ungvien (ID_UngVien, ID_TaiKhoan, Ten, Email) VALUES (?, ?, ?, ?)",
                        [$applicantId, $userId, 'Chưa cập nhật', $user['Email']]
                    );
                }
            }
            
            $db->commit();
            setFlash('success', 'Đã thay đổi vai trò thành công');
            
        } catch (Exception $e) {
            $db->rollback();
            setFlash('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
        
        $this->redirect('/admin/users/' . $userId);
    }
}
