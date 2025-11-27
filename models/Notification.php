<?php
class Notification {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo thông báo
    public function create($applicantId, $data) {
        $id = generateId('TB');
        
        $sql = "INSERT INTO THONGBAOUNGTUYEN (
                    ID_ThongBao, ID_UngVien, ID_DonUngTuyen, 
                    TieuDe, NoiDung, LoaiThongBao
                ) VALUES (?, ?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $id,
            $applicantId,
            $data['don_ung_tuyen_id'] ?? null,
            $data['tieu_de'],
            $data['noi_dung'] ?? '',
            $data['loai'] ?? 'Hệ thống'
        ]);
        
        return $id;
    }
    
    // Lấy thông báo của ứng viên
    public function getByApplicant($applicantId, $limit = 20, $offset = 0) {
        $sql = "SELECT *, LoaiThongBao as Loai FROM THONGBAOUNGTUYEN 
                WHERE ID_UngVien = ?
                ORDER BY NgayTao DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$applicantId, $limit, $offset]);
    }
    
    // Đếm thông báo chưa đọc
    public function countUnread($applicantId) {
        $sql = "SELECT COUNT(*) as total FROM THONGBAOUNGTUYEN 
                WHERE ID_UngVien = ? AND DaDoc = FALSE";
        $result = $this->db->fetchOne($sql, [$applicantId]);
        return $result['total'];
    }
    
    // Đánh dấu đã đọc
    public function markAsRead($id) {
        $sql = "UPDATE THONGBAOUNGTUYEN SET DaDoc = TRUE WHERE ID_ThongBao = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    // Đánh dấu tất cả đã đọc
    public function markAllAsRead($applicantId) {
        $sql = "UPDATE THONGBAOUNGTUYEN SET DaDoc = TRUE WHERE ID_UngVien = ?";
        return $this->db->execute($sql, [$applicantId]);
    }
    
    // Xóa thông báo
    public function delete($id) {
        $sql = "DELETE FROM THONGBAOUNGTUYEN WHERE ID_ThongBao = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    // Gửi thông báo cho ứng viên về đơn ứng tuyển
    public function notifyApplicationStatus($applicationId, $status) {
        // Lấy thông tin đơn ứng tuyển
        $sql = "SELECT dut.ID_UngVien, bd.TieuDe, ntd.Ten as ten_cong_ty
                FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE dut.ID_DonUngTuyen = ?";
        
        $app = $this->db->fetchOne($sql, [$applicationId]);
        
        if ($app) {
            $messages = [
                'Đã xem' => 'Nhà tuyển dụng đã xem hồ sơ của bạn',
                'Mời phỏng vấn' => 'Chúc mừng! Bạn đã được mời phỏng vấn',
                'Từ chối' => 'Rất tiếc, hồ sơ của bạn chưa phù hợp lần này',
                'Trúng tuyển' => 'Chúc mừng! Bạn đã trúng tuyển'
            ];
            
            $title = $messages[$status] ?? 'Cập nhật trạng thái đơn ứng tuyển';
            $content = "Đơn ứng tuyển của bạn cho vị trí \"{$app['TieuDe']}\" tại {$app['ten_cong_ty']} đã được cập nhật: {$status}";
            
            $this->create($app['ID_UngVien'], [
                'don_ung_tuyen_id' => $applicationId,
                'tieu_de' => $title,
                'noi_dung' => $content,
                'loai' => 'Ứng tuyển'
            ]);
        }
    }
    
    // Alias cho getByApplicant
    public function getByUser($userId, $limit = 20, $offset = 0) {
        return $this->getByApplicant($userId, $limit, $offset);
    }
    
    // Lấy thông báo theo đơn ứng tuyển
    public function getByApplication($applicationId) {
        $sql = "SELECT *, LoaiThongBao as Loai FROM THONGBAOUNGTUYEN 
                WHERE ID_DonUngTuyen = ?
                ORDER BY NgayTao DESC";
        
        return $this->db->fetchAll($sql, [$applicationId]);
    }
    
    // Gửi thông báo cho nhà tuyển dụng về đơn ứng tuyển mới
    public function notifyNewApplication($employerId, $applicationId) {
        // Lấy thông tin đơn ứng tuyển
        $sql = "SELECT dut.*, bd.TieuDe, uv.HoLot, uv.Ten
                FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN UNGVIEN uv ON dut.ID_UngVien = uv.ID_UngVien
                WHERE dut.ID_DonUngTuyen = ?";
        
        $app = $this->db->fetchOne($sql, [$applicationId]);
        
        if ($app) {
            $title = 'Có ứng viên mới ứng tuyển';
            $content = "{$app['HoLot']} {$app['Ten']} đã ứng tuyển vào vị trí \"{$app['TieuDe']}\"";
            
            // Tạo thông báo cho nhà tuyển dụng (cần bảng riêng hoặc dùng chung)
            // Tạm thời skip vì chưa có bảng thông báo cho employer
        }
    }
}
