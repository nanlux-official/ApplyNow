<?php
class Review {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo đánh giá
    public function create($employerId, $applicantId, $data) {
        // Kiểm tra đã đánh giá chưa
        if ($this->hasReviewed($employerId, $applicantId)) {
            return false;
        }
        
        $id = generateId('DG');
        
        $sql = "INSERT INTO DANHGIA (ID_DanhGia, ID_NhaTuyenDung, ID_UngVien, DiemDanhGia, NhanXet) 
                VALUES (?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $id,
            $employerId,
            $applicantId,
            $data['diem'],
            $data['nhan_xet'] ?? ''
        ]);
        
        return $id;
    }
    
    // Cập nhật đánh giá
    public function update($id, $data) {
        $sql = "UPDATE DANHGIA SET DiemDanhGia = ?, NhanXet = ? WHERE ID_DanhGia = ?";
        return $this->db->execute($sql, [$data['diem'], $data['nhan_xet'] ?? '', $id]);
    }
    
    // Xóa đánh giá
    public function delete($id) {
        $sql = "DELETE FROM DANHGIA WHERE ID_DanhGia = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    // Kiểm tra đã đánh giá chưa
    public function hasReviewed($employerId, $applicantId) {
        $sql = "SELECT COUNT(*) as count FROM DANHGIA 
                WHERE ID_NhaTuyenDung = ? AND ID_UngVien = ?";
        $result = $this->db->fetchOne($sql, [$employerId, $applicantId]);
        return $result['count'] > 0;
    }
    
    // Lấy đánh giá của ứng viên cho nhà tuyển dụng
    public function getByApplicantAndEmployer($employerId, $applicantId) {
        $sql = "SELECT * FROM DANHGIA 
                WHERE ID_NhaTuyenDung = ? AND ID_UngVien = ?";
        return $this->db->fetchOne($sql, [$employerId, $applicantId]);
    }
    
    // Lấy đánh giá theo ID
    public function findById($id) {
        $sql = "SELECT dg.*, ntd.Ten as ten_cong_ty, uv.HoLot, uv.Ten as ten_ungvien
                FROM DANHGIA dg
                INNER JOIN NHATUYENDUNG ntd ON dg.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                INNER JOIN UNGVIEN uv ON dg.ID_UngVien = uv.ID_UngVien
                WHERE dg.ID_DanhGia = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Lấy đánh giá của nhà tuyển dụng
    public function getByEmployer($employerId, $limit = 20, $offset = 0) {
        $sql = "SELECT dg.*, uv.HoLot, uv.Ten as ten_ungvien, uv.AnhDaiDien
                FROM DANHGIA dg
                INNER JOIN UNGVIEN uv ON dg.ID_UngVien = uv.ID_UngVien
                WHERE dg.ID_NhaTuyenDung = ?
                ORDER BY dg.NgayDanhGia DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$employerId, $limit, $offset]);
    }
    
    // Đếm số đánh giá
    public function count($employerId) {
        $sql = "SELECT COUNT(*) as total FROM DANHGIA WHERE ID_NhaTuyenDung = ?";
        $result = $this->db->fetchOne($sql, [$employerId]);
        return $result['total'];
    }
    
    // Lấy điểm trung bình
    public function getAverageRating($employerId) {
        $sql = "SELECT AVG(DiemDanhGia) as avg_rating FROM DANHGIA WHERE ID_NhaTuyenDung = ?";
        $result = $this->db->fetchOne($sql, [$employerId]);
        return round($result['avg_rating'] ?? 0, 1);
    }
}
