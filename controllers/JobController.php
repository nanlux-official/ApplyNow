<?php
class JobController extends Controller {
    private $jobModel;
    private $employerModel;
    private $savedJobModel;
    
    public function __construct() {
        parent::__construct();
        $this->jobModel = new Job();
        $this->employerModel = new Employer();
        $this->savedJobModel = new SavedJob();
    }
    
    // Trang chủ - danh sách việc làm
    public function index() {
        $page = input('page', 1);
        $filters = [
            'keyword' => input('keyword'),
            'dia_diem' => input('dia_diem'),
            'loai_cong_viec' => input('loai_cong_viec'),
            'kinh_nghiem' => input('kinh_nghiem'),
            'linh_vuc' => input('linh_vuc'),
            'sort' => input('sort')
        ];
        
        $totalJobs = $this->jobModel->countSearch($filters);
        $pagination = paginate($totalJobs, $page);
        
        $jobs = $this->jobModel->search($filters, $pagination['items_per_page'], $pagination['offset']);
        
        $this->view('jobs/search', [
            'jobs' => $jobs,
            'filters' => $filters,
            'pagination' => $pagination
        ]);
    }
    
    // Chi tiết công việc
    public function detail($id) {
        $job = $this->jobModel->findById($id);
        
        if (!$job) {
            setFlash('error', 'Công việc không tồn tại');
            $this->redirect('/jobs');
            return;
        }
        
        $isSaved = false;
        $hasReviewed = false;
        if ($this->isLoggedIn() && $this->hasRole('APPLICANT')) {
            $applicant = (new Applicant())->findByUserId($this->getCurrentUser()['id']);
            if ($applicant) {
                $isSaved = $this->savedJobModel->isSaved($applicant['ID_UngVien'], $id);
                $hasReviewed = (new Review())->hasReviewed($job['ID_NhaTuyenDung'], $applicant['ID_UngVien']);
            }
        }
        
        // Lấy đánh giá của nhà tuyển dụng
        $reviewModel = new Review();
        $reviews = $reviewModel->getByEmployer($job['ID_NhaTuyenDung'], 10, 0);
        $avgRating = $reviewModel->getAverageRating($job['ID_NhaTuyenDung']);
        $totalReviews = $reviewModel->count($job['ID_NhaTuyenDung']);
        
        $this->view('jobs/detail', [
            'job' => $job,
            'is_saved' => $isSaved,
            'has_reviewed' => $hasReviewed,
            'reviews' => $reviews,
            'avg_rating' => $avgRating,
            'total_reviews' => $totalReviews
        ]);
    }
    
    // Lưu công việc (AJAX)
    public function save($id) {
        Middleware::applicant();
        
        $applicant = (new Applicant())->findByUserId($this->getCurrentUser()['id']);
        
        if ($this->savedJobModel->save($applicant['ID_UngVien'], $id)) {
            $this->json(['success' => true, 'message' => 'Đã lưu công việc']);
        } else {
            $this->json(['success' => false, 'message' => 'Công việc đã được lưu trước đó'], 400);
        }
    }
    
    // Bỏ lưu công việc (AJAX)
    public function unsave($id) {
        Middleware::applicant();
        
        $applicant = (new Applicant())->findByUserId($this->getCurrentUser()['id']);
        
        if ($this->savedJobModel->unsave($applicant['ID_UngVien'], $id)) {
            $this->json(['success' => true, 'message' => 'Đã bỏ lưu công việc']);
        } else {
            $this->json(['success' => false, 'message' => 'Có lỗi xảy ra'], 400);
        }
    }
    
    // Hiển thị form ứng tuyển
    public function showApply($id) {
        Middleware::applicant();
        
        $job = $this->jobModel->findById($id);
        if (!$job) {
            setFlash('error', 'Công việc không tồn tại');
            $this->redirect('/jobs');
            return;
        }
        
        $applicant = (new Applicant())->findByUserId($this->getCurrentUser()['id']);
        
        // Kiểm tra đã ứng tuyển chưa
        $applicationModel = new Application();
        if ($applicationModel->hasApplied($id, $applicant['ID_UngVien'])) {
            setFlash('error', 'Bạn đã ứng tuyển công việc này rồi');
            $this->redirect('/jobs/' . $id);
            return;
        }
        
        $this->view('jobs/apply', [
            'title' => 'Ứng tuyển - ' . $job['TieuDe'],
            'job' => $job,
            'applicant' => $applicant
        ]);
    }
    
    // Xử lý ứng tuyển
    public function apply($id) {
        Middleware::applicant();
        
        if (!isPost()) {
            $this->redirect('/jobs/' . $id);
            return;
        }
        
        $job = $this->jobModel->findById($id);
        if (!$job) {
            setFlash('error', 'Công việc không tồn tại');
            $this->redirect('/jobs');
            return;
        }
        
        $applicant = (new Applicant())->findByUserId($this->getCurrentUser()['id']);
        $applicationModel = new Application();
        
        // Kiểm tra đã ứng tuyển chưa
        if ($applicationModel->hasApplied($id, $applicant['ID_UngVien'])) {
            setFlash('error', 'Bạn đã ứng tuyển công việc này rồi');
            $this->redirect('/jobs/' . $id);
            return;
        }
        
        // Upload CV nếu có
        $cvFile = null;
        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['cv_file'], 'cv', ['pdf', 'doc', 'docx']);
            if ($upload['success']) {
                $cvFile = $upload['filename'];
            } else {
                setFlash('error', 'Lỗi upload CV: ' . ($upload['message'] ?? 'Lỗi không xác định'));
                $this->redirect('/jobs/' . $id . '/apply');
                return;
            }
        } else {
            // File không được chọn hoặc có lỗi
            if (!isset($_FILES['cv_file'])) {
                setFlash('error', 'Vui lòng chọn file CV');
            } else {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File quá lớn (vượt quá giới hạn PHP)',
                    UPLOAD_ERR_FORM_SIZE => 'File quá lớn',
                    UPLOAD_ERR_PARTIAL => 'File chỉ được upload một phần',
                    UPLOAD_ERR_NO_FILE => 'Không có file được chọn',
                    UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm',
                    UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file',
                    UPLOAD_ERR_EXTENSION => 'Upload bị chặn bởi extension'
                ];
                $error = $_FILES['cv_file']['error'];
                $errorMsg = $errorMessages[$error] ?? "Lỗi upload không xác định (code: {$error})";
                setFlash('error', $errorMsg);
            }
            $this->redirect('/jobs/' . $id . '/apply');
            return;
        }
        
        $data = [
            'file_cv' => $cvFile,
            'thu_xin_viec' => input('thu_xin_viec')
        ];
        
        $applicationId = $applicationModel->create($id, $applicant['ID_UngVien'], $data);
        
        if ($applicationId) {
            // Gửi thông báo cho nhà tuyển dụng
            $notificationModel = new Notification();
            $notificationModel->notifyNewApplication($job['ID_NhaTuyenDung'], $applicationId);
            
            setFlash('success', 'Ứng tuyển thành công! Nhà tuyển dụng sẽ liên hệ với bạn sớm.');
            $this->redirect('/applicant/applications');
        } else {
            setFlash('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            $this->redirect('/jobs/' . $id . '/apply');
        }
    }
}
