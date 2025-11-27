<?php
class Employer {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo profile nhà tuyển dụng
    public function create($userId, $data) {
        $id = generateId('NTD');
        
        $sql = "INSERT INTO NHATUYENDUNG (ID_NhaTuyenDung, ID_TaiKhoan, Ten, MoTa, TrangWeb, DiaChi, SDT, Email, QuyMo, LinhVuc) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $id,
            $userId,
            $data['ten'],
            $data['mo_ta'] ?? '',
            $data['trang_web'] ?? '',
            $data['dia_chi'] ?? '',
            $data['sdt'] ?? '',
            $data['email'],
            $data['quy_mo'] ?? '',
            $data['linh_vuc'] ?? ''
        ]);
        
        return $id;
    }
    
    // Lấy thông tin nhà tuyển dụng theo user ID
    public function findByUserId($userId) {
        $sql = "SELECT * FROM NHATUYENDUNG WHERE ID_TaiKhoan = ?";
        return $this->db->fetchOne($sql, [$userId]);
    }
    
    // Lấy thông tin nhà tuyển dụng theo ID
    public function findById($id) {
        $sql = "SELECT ntd.*, tk.Email as email_taikhoan, tk.TrangThai 
                FROM NHATUYENDUNG ntd
                INNER JOIN TAIKHOAN tk ON ntd.ID_TaiKhoan = tk.ID_TaiKhoan
                WHERE ntd.ID_NhaTuyenDung = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Cập nhật thông tin nhà tuyển dụng
    public function update($id, $data) {
        $sql = "UPDATE NHATUYENDUNG SET 
                Ten = ?, MoTa = ?, TrangWeb = ?, DiaChi = ?, 
                SDT = ?, Email = ?, Logo = ?, QuyMo = ?, LinhVuc = ?
                WHERE ID_NhaTuyenDung = ?";
        
        return $this->db->execute($sql, [
            $data['ten'],
            $data['mo_ta'] ?? '',
            $data['trang_web'] ?? '',
            $data['dia_chi'] ?? '',
            $data['sdt'] ?? '',
            $data['email'],
            $data['logo'] ?? null,
            $data['quy_mo'] ?? '',
            $data['linh_vuc'] ?? '',
            $id
        ]);
    }
    
    // Lấy thống kê của nhà tuyển dụng
    public function getStats($employerId) {
        $stats = [];
        
        // Tổng số bài đăng
        $sql = "SELECT COUNT(*) as total FROM BAIDANG WHERE ID_NhaTuyenDung = ?";
        $result = $this->db->fetchOne($sql, [$employerId]);
        $stats['total_jobs'] = $result['total'];
        
        // Bài đăng đang active
        $sql = "SELECT COUNT(*) as total FROM BAIDANG WHERE ID_NhaTuyenDung = ? AND TrangThai = 'active'";
        $result = $this->db->fetchOne($sql, [$employerId]);
        $stats['active_jobs'] = $result['total'];
        
        // Tổng số đơn ứng tuyển
        $sql = "SELECT COUNT(*) as total FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                WHERE bd.ID_NhaTuyenDung = ?";
        $result = $this->db->fetchOne($sql, [$employerId]);
        $stats['total_applications'] = $result['total'];
        
        // Đơn ứng tuyển mới
        $sql = "SELECT COUNT(*) as total FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                WHERE bd.ID_NhaTuyenDung = ? AND dut.TrangThai = 'Mới nộp'";
        $result = $this->db->fetchOne($sql, [$employerId]);
        $stats['new_applications'] = $result['total'];
        
        // Điểm đánh giá trung bình
        $sql = "SELECT AVG(DiemDanhGia) as avg_rating, COUNT(*) as total_reviews 
                FROM DANHGIA WHERE ID_NhaTuyenDung = ?";
        $result = $this->db->fetchOne($sql, [$employerId]);
        $stats['avg_rating'] = round($result['avg_rating'] ?? 0, 1);
        $stats['total_reviews'] = $result['total_reviews'];
        
        return $stats;
    }
    
    // Lấy đánh giá của nhà tuyển dụng
    public function getReviews($employerId, $limit = 10, $offset = 0) {
        $sql = "SELECT dg.*, uv.HoLot, uv.Ten, uv.AnhDaiDien
                FROM DANHGIA dg
                INNER JOIN UNGVIEN uv ON dg.ID_UngVien = uv.ID_UngVien
                WHERE dg.ID_NhaTuyenDung = ?
                ORDER BY dg.NgayDanhGia DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$employerId, $limit, $offset]);
    }
    
    // Lấy danh sách tất cả nhà tuyển dụng
    public function getAll($limit = 50, $offset = 0) {
        $sql = "SELECT ntd.*, tk.Email, tk.TrangThai,
                (SELECT COUNT(*) FROM BAIDANG WHERE ID_NhaTuyenDung = ntd.ID_NhaTuyenDung) as total_jobs
                FROM NHATUYENDUNG ntd
                INNER JOIN TAIKHOAN tk ON ntd.ID_TaiKhoan = tk.ID_TaiKhoan
                ORDER BY ntd.NgayTao DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }
    
    // Đếm tổng số nhà tuyển dụng
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM NHATUYENDUNG";
        $result = $this->db->fetchOne($sql);
        return $result['total'];
    }
}
