<?php
class SupportController extends Controller {
    private $ticketModel;
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->ticketModel = new SupportTicket();
        $this->userModel = new User();
    }
    
    // Danh sách tickets của user
    public function myTickets() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $userType = $currentUser['role'] === 'APPLICANT' ? 'APPLICANT' : 'EMPLOYER';
        
        // Lấy ID tương ứng
        if ($userType === 'APPLICANT') {
            $applicant = (new Applicant())->findByUserId($currentUser['id']);
            if (!$applicant) {
                setFlash('error', 'Không tìm thấy thông tin ứng viên');
                $this->redirect('/applicant/profile');
                return;
            }
            $userId = $applicant['ID_UngVien'];
        } else {
            $employer = (new Employer())->findByUserId($currentUser['id']);
            if (!$employer) {
                setFlash('error', 'Không tìm thấy thông tin nhà tuyển dụng');
                $this->redirect('/employer/profile');
                return;
            }
            $userId = $employer['ID_NhaTuyenDung'];
        }
        
        $tickets = $this->ticketModel->getByUser($userId);
        
        $this->view('support/my-tickets', [
            'title' => 'Yêu cầu hỗ trợ của tôi',
            'tickets' => $tickets
        ]);
    }
    
    // Form tạo ticket mới
    public function create() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }
        
        $this->view('support/create', [
            'title' => 'Tạo yêu cầu hỗ trợ'
        ]);
    }
    
    // Xử lý tạo ticket
    public function store() {
        if (!$this->isLoggedIn() || !isPost()) {
            $this->redirect('/support');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $userType = $currentUser['role'] === 'APPLICANT' ? 'APPLICANT' : 'EMPLOYER';
        
        // Lấy ID tương ứng
        if ($userType === 'APPLICANT') {
            $applicant = (new Applicant())->findByUserId($currentUser['id']);
            if (!$applicant) {
                setFlash('error', 'Không tìm thấy thông tin ứng viên');
                $this->redirect('/support');
                return;
            }
            $userId = $applicant['ID_UngVien'];
        } else {
            $employer = (new Employer())->findByUserId($currentUser['id']);
            if (!$employer) {
                setFlash('error', 'Không tìm thấy thông tin nhà tuyển dụng');
                $this->redirect('/support');
                return;
            }
            $userId = $employer['ID_NhaTuyenDung'];
        }
        
        $data = [
            'tieu_de' => input('tieu_de'),
            'noi_dung' => input('noi_dung'),
            'do_uu_tien' => input('do_uu_tien', 'Trung bình')
        ];
        
        $ticketId = $this->ticketModel->create($userId, $userType, $data);
        
        if ($ticketId) {
            setFlash('success', 'Yêu cầu hỗ trợ đã được gửi. Chúng tôi sẽ phản hồi sớm nhất.');
            $this->redirect('/support/tickets/' . $ticketId);
        } else {
            setFlash('error', 'Có lỗi xảy ra');
            $this->redirect('/support/create');
        }
    }
    
    // Chi tiết ticket
    public function detail($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }
        
        $ticket = $this->ticketModel->findById($id);
        
        if (!$ticket) {
            setFlash('error', 'Không tìm thấy yêu cầu hỗ trợ');
            $this->redirect('/support');
            return;
        }
        
        // Kiểm tra quyền
        $currentUser = $this->getCurrentUser();
        if ($currentUser['role'] !== 'ADMIN') {
            $userType = $currentUser['role'] === 'APPLICANT' ? 'APPLICANT' : 'EMPLOYER';
            
            if ($userType === 'APPLICANT') {
                $applicant = (new Applicant())->findByUserId($currentUser['id']);
                if (!$applicant) {
                    setFlash('error', 'Không tìm thấy thông tin ứng viên');
                    $this->redirect('/support');
                    return;
                }
                $userId = $applicant['ID_UngVien'];
            } else {
                $employer = (new Employer())->findByUserId($currentUser['id']);
                if (!$employer) {
                    setFlash('error', 'Không tìm thấy thông tin nhà tuyển dụng');
                    $this->redirect('/support');
                    return;
                }
                $userId = $employer['ID_NhaTuyenDung'];
            }
            
            if ($ticket['ID_NguoiDung'] !== $userId) {
                setFlash('error', 'Bạn không có quyền xem yêu cầu này');
                $this->redirect('/support');
                return;
            }
        }
        
        $replies = $this->ticketModel->getReplies($id);
        
        $this->view('support/detail', [
            'title' => 'Chi tiết yêu cầu hỗ trợ',
            'ticket' => $ticket,
            'replies' => $replies
        ]);
    }
    
    // Thêm reply
    public function addReply($id) {
        if (!$this->isLoggedIn() || !isPost()) {
            $this->redirect('/support');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        $userType = $currentUser['role'] === 'ADMIN' ? 'ADMIN' : 'USER';
        
        $content = input('noi_dung');
        
        if ($this->ticketModel->addReply($id, $currentUser['id'], $userType, $content)) {
            setFlash('success', 'Đã thêm phản hồi');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->redirect('/support/tickets/' . $id);
    }
    
    // Admin: Danh sách tất cả tickets
    public function adminList() {
        Middleware::admin();
        
        $filters = [
            'trang_thai' => input('trang_thai'),
            'do_uu_tien' => input('do_uu_tien')
        ];
        
        $tickets = $this->ticketModel->getAll($filters);
        $stats = [
            'total' => $this->ticketModel->count([]),
            'new' => $this->ticketModel->count(['trang_thai' => 'Mới']),
            'processing' => $this->ticketModel->count(['trang_thai' => 'Đang xử lý']),
            'resolved' => $this->ticketModel->count(['trang_thai' => 'Đã giải quyết'])
        ];
        
        $this->view('admin/support-tickets', [
            'title' => 'Quản lý yêu cầu hỗ trợ',
            'tickets' => $tickets,
            'filters' => $filters,
            'stats' => $stats
        ]);
    }
    
    // Admin: Cập nhật trạng thái
    public function updateStatus($id) {
        Middleware::admin();
        
        if (!isPost()) {
            $this->redirect('/admin/support');
            return;
        }
        
        $status = input('status');
        $note = input('note');
        $currentUser = $this->getCurrentUser();
        
        if ($this->ticketModel->updateStatus($id, $status, $currentUser['id'], $note)) {
            setFlash('success', 'Cập nhật trạng thái thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra');
        }
        
        $this->back();
    }
    
    // Form yêu cầu nâng cấp lên Employer
    public function showUpgradeEmployer() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        if ($currentUser['role'] !== 'APPLICANT') {
            setFlash('error', 'Chỉ ứng viên mới có thể yêu cầu nâng cấp');
            $this->redirect('/');
            return;
        }
        
        $this->view('support/upgrade-employer', [
            'title' => 'Yêu cầu trở thành Nhà tuyển dụng'
        ]);
    }
    
    // Xử lý yêu cầu nâng cấp
    public function submitUpgradeEmployer() {
        if (!$this->isLoggedIn() || !isPost()) {
            $this->redirect('/support');
            return;
        }
        
        $currentUser = $this->getCurrentUser();
        if ($currentUser['role'] !== 'APPLICANT') {
            setFlash('error', 'Chỉ ứng viên mới có thể yêu cầu nâng cấp');
            $this->redirect('/');
            return;
        }
        
        $applicant = (new Applicant())->findByUserId($currentUser['id']);
        if (!$applicant) {
            setFlash('error', 'Không tìm thấy thông tin ứng viên');
            $this->redirect('/support');
            return;
        }
        
        // Tạo nội dung ticket
        $content = "=== YÊU CẦU NÂNG CẤP LÊN NHÀ TUYỂN DỤNG ===\n\n";
        $content .= "THÔNG TIN CÔNG TY:\n";
        $content .= "- Tên công ty: " . input('ten_cong_ty') . "\n";
        $content .= "- Mã số thuế: " . input('ma_so_thue') . "\n";
        $content .= "- Địa chỉ: " . input('dia_chi') . "\n";
        $content .= "- Số điện thoại: " . input('so_dien_thoai') . "\n";
        $content .= "- Email công ty: " . input('email_cong_ty') . "\n";
        $content .= "- Website: " . (input('website') ?: 'Không có') . "\n";
        $content .= "- Quy mô: " . input('quy_mo') . "\n";
        $content .= "- Lĩnh vực: " . input('linh_vuc') . "\n\n";
        $content .= "MÔ TẢ CÔNG TY:\n" . input('mo_ta') . "\n\n";
        $content .= "LÝ DO:\n" . input('ly_do');
        
        $data = [
            'tieu_de' => '🏢 Yêu cầu nâng cấp lên Nhà tuyển dụng - ' . input('ten_cong_ty'),
            'noi_dung' => $content,
            'do_uu_tien' => 'Cao'
        ];
        
        $ticketId = $this->ticketModel->create($applicant['ID_UngVien'], 'APPLICANT', $data);
        
        if ($ticketId) {
            setFlash('success', 'Yêu cầu đã được gửi. Chúng tôi sẽ xem xét và phản hồi trong 1-3 ngày làm việc.');
            $this->redirect('/support/tickets/' . $ticketId);
        } else {
            setFlash('error', 'Có lỗi xảy ra');
            $this->redirect('/support/upgrade-employer');
        }
    }
}
