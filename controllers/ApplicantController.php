<?php
class ApplicantController extends Controller {
    private $applicantModel;
    private $jobModel;
    private $applicationModel;
    private $savedJobModel;
    private $notificationModel;
    private $reviewModel;
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->applicantModel = new Applicant();
        $this->jobModel = new Job();
        $this->applicationModel = new Application();
        $this->savedJobModel = new SavedJob();
        $this->notificationModel = new Notification();
        $this->reviewModel = new Review();
        $this->userModel = new User();
    }
    
    // Dashboard ứng viên
    public function dashboard() {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        if (!$applicant) {
            setFlash('error', 'Không tìm thấy thông tin ứng viên');
            $this->redirect('/logout');
            return;
        }
        
        // Thống kê
        $stats = [
            'applications' => $this->applicationModel->countByApplicant($applicant['ID_UngVien'], []),
            'saved_jobs' => $this->savedJobModel->countByApplicant($applicant['ID_UngVien']),
            'pending' => $this->applicationModel->countByApplicant($applicant['ID_UngVien'], ['trang_thai' => 'Mới nộp']),
            'interviews' => $this->applicationModel->countByApplicant($applicant['ID_UngVien'], ['trang_thai' => 'Mời phỏng vấn'])
        ];
        
        // Đơn ứng tuyển gần đây
        $recentApplications = $this->applicationModel->getByApplicant($applicant['ID_UngVien'], [], 5, 0);
        
        // Công việc đề xuất
        $recommendedJobs = $this->jobModel->getRecommended($applicant['ID_UngVien'], 6);
        
        // Thông báo mới
        $notifications = $this->notificationModel->getByUser($applicant['ID_UngVien'], 5);
        
        $this->view('applicant/dashboard', [
            'title' => 'Dashboard Ứng viên',
            'applicant' => $applicant,
            'stats' => $stats,
            'recent_applications' => $recentApplications,
            'recommended_jobs' => $recommendedJobs,
            'notifications' => $notifications
        ]);
    }
    
    // Hồ sơ cá nhân
    public function profile() {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        $this->view('applicant/profile', [
            'title' => 'Hồ sơ cá nhân',
            'applicant' => $applicant
        ]);
    }
    
    // Cập nhật hồ sơ
    public function updateProfile() {
        Middleware::applicant();
        
        if (!isPost()) {
            $this->redirect('/applicant/profile');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        $data = [
            'ho_lot' => input('ho_lot'),
            'ten' => input('ten'),
            'email' => input('email'),
            'sdt' => input('sdt'),
            'dia_chi' => input('dia_chi'),
            'ngay_sinh' => input('ngay_sinh'),
            'gioi_tinh' => input('gioi_tinh'),
            'ky_nang' => input('ky_nang'),
            'kinh_nghiem' => input('kinh_nghiem'),
            'hoc_van' => input('hoc_van')
        ];
        
        if ($this->applicantModel->update($applicant['ID_UngVien'], $data)) {
            setFlash('success', 'Cập nhật hồ sơ thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/applicant/profile');
    }
    
    // Lịch sử ứng tuyển
    public function applications() {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        $filters = [
            'trang_thai' => input('trang_thai')
        ];
        
        $page = input('page', 1);
        $applications = $this->applicationModel->getByApplicant($applicant['ID_UngVien'], $filters, 20, ($page - 1) * 20);
        
        $this->view('applicant/applications', [
            'title' => 'Lịch sử ứng tuyển',
            'applications' => $applications,
            'filters' => $filters
        ]);
    }
    
    // Chi tiết đơn ứng tuyển
    public function applicationDetail($id) {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        $application = $this->applicationModel->findById($id);
        
        if (!$application || $application['ID_UngVien'] !== $applicant['ID_UngVien']) {
            setFlash('error', 'Không tìm thấy đơn ứng tuyển');
            $this->redirect('/applicant/applications');
            return;
        }
        
        // Lấy thông báo liên quan đến đơn này
        $notifications = $this->notificationModel->getByApplication($id);
        
        $this->view('applicant/application-detail', [
            'title' => 'Chi tiết đơn ứng tuyển',
            'application' => $application,
            'notifications' => $notifications
        ]);
    }
    
    // Xóa đơn ứng tuyển
    public function deleteApplication($id) {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        $application = $this->applicationModel->findById($id);
        
        // Kiểm tra quyền
        if (!$application || $application['ID_UngVien'] !== $applicant['ID_UngVien']) {
            setFlash('error', 'Không tìm thấy đơn ứng tuyển');
            $this->redirect('/applicant/applications');
            return;
        }
        
        // Chỉ cho phép xóa đơn có trạng thái "Mới nộp" hoặc "Từ chối"
        if (!in_array($application['TrangThai'], ['Mới nộp', 'Từ chối'])) {
            setFlash('error', 'Chỉ có thể xóa đơn có trạng thái "Mới nộp" hoặc "Từ chối"');
            $this->redirect('/applicant/applications');
            return;
        }
        
        if ($this->applicationModel->delete($id)) {
            setFlash('success', 'Đã xóa đơn ứng tuyển');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/applicant/applications');
    }
    
    // Công việc đã lưu
    public function savedJobs() {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        $page = input('page', 1);
        $savedJobs = $this->savedJobModel->getByApplicant($applicant['ID_UngVien'], 20, ($page - 1) * 20);
        
        $this->view('applicant/saved-jobs', [
            'title' => 'Công việc đã lưu',
            'saved_jobs' => $savedJobs
        ]);
    }
    
    // Lưu công việc
    public function saveJob($jobId) {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        if ($this->savedJobModel->toggle($jobId, $applicant['ID_UngVien'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    
    // Bỏ lưu công việc
    public function removeSavedJob($jobId) {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        if ($this->savedJobModel->unsave($applicant['ID_UngVien'], $jobId)) {
            echo json_encode(['success' => true, 'message' => 'Đã bỏ lưu công việc']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra']);
        }
    }
    
    // Thông báo
    public function notifications() {
        Middleware::applicant();
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        $page = input('page', 1);
        $notifications = $this->notificationModel->getByUser($applicant['ID_UngVien'], 20, ($page - 1) * 20);
        
        // Đánh dấu đã đọc
        $this->notificationModel->markAsRead($applicant['ID_UngVien']);
        
        $this->view('applicant/notifications', [
            'title' => 'Thông báo',
            'notifications' => $notifications
        ]);
    }
    
    // Đánh giá nhà tuyển dụng
    public function reviewEmployer($employerId) {
        Middleware::applicant();
        
        if (!isPost()) {
            $this->redirect('/jobs');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $applicant = $this->applicantModel->findByUserId($currentUser['id']);
        
        $data = [
            'diem' => input('rating'),
            'nhan_xet' => input('content')
        ];
        
        // Validate
        if (empty($data['diem']) || $data['diem'] < 1 || $data['diem'] > 5) {
            setFlash('error', 'Vui lòng chọn điểm đánh giá từ 1-5 sao');
            $this->back();
            return;
        }
        
        if ($this->reviewModel->create($employerId, $applicant['ID_UngVien'], $data)) {
            setFlash('success', 'Đánh giá thành công');
        } else {
            setFlash('error', 'Bạn đã đánh giá nhà tuyển dụng này rồi');
        }
        
        $this->back();
    }
    
    // Đổi mật khẩu
    public function changePassword() {
        Middleware::applicant();
        
        if (!isPost()) {
            $this->redirect('/applicant/profile');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $oldPassword = input('old_password');
        $newPassword = input('new_password');
        $confirmPassword = input('confirm_password');
        
        if ($newPassword !== $confirmPassword) {
            setFlash('error', 'Mật khẩu xác nhận không khớp');
            $this->redirect('/applicant/profile');
            return;
        }
        
        if ($this->userModel->changePassword($currentUser['id'], $oldPassword, $newPassword)) {
            setFlash('success', 'Đổi mật khẩu thành công');
        } else {
            setFlash('error', 'Mật khẩu cũ không đúng');
        }
        
        $this->redirect('/applicant/profile');
    }
}
