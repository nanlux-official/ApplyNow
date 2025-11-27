<?php
class Applicant {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo profile ứng viên
    public function create($userId, $data) {
        $id = generateId('UV');
        
        $sql = "INSERT INTO UNGVIEN (ID_UngVien, ID_TaiKhoan, HoLot, Ten, SDT, Email, NgaySinh, GioiTinh, DiaChi) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $id,
            $userId,
            $data['ho_lot'] ?? '',
            $data['ten'],
            $data['sdt'] ?? '',
            $data['email'],
            $data['ngay_sinh'] ?? null,
            $data['gioi_tinh'] ?? null,
            $data['dia_chi'] ?? ''
        ]);
        
        return $id;
    }
    
    // Lấy thông tin ứng viên theo user ID
    public function findByUserId($userId) {
        $sql = "SELECT uv.*, hs.KyNang, hs.KinhNghiem, hs.HocVan
                FROM UNGVIEN uv
                LEFT JOIN HOSO hs ON uv.ID_UngVien = hs.ID_UngVien
                WHERE uv.ID_TaiKhoan = ?";
        return $this->db->fetchOne($sql, [$userId]);
    }
    
    // Lấy thông tin ứng viên theo ID
    public function findById($id) {
        $sql = "SELECT uv.*, tk.Email as email_taikhoan, tk.TrangThai 
                FROM UNGVIEN uv
                INNER JOIN TAIKHOAN tk ON uv.ID_TaiKhoan = tk.ID_TaiKhoan
                WHERE uv.ID_UngVien = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Cập nhật thông tin ứng viên
    public function update($id, $data) {
        // Cập nhật thông tin cơ bản
        $sql = "UPDATE UNGVIEN SET 
                HoLot = ?, Ten = ?, SDT = ?, NgaySinh = ?, 
                GioiTinh = ?, DiaChi = ?, Email = ?
                WHERE ID_UngVien = ?";
        
        $result = $this->db->execute($sql, [
            $data['ho_lot'] ?? '',
            $data['ten'],
            $data['sdt'] ?? '',
            $data['ngay_sinh'] ?? null,
            $data['gioi_tinh'] ?? null,
            $data['dia_chi'] ?? '',
            $data['email'] ?? '',
            $id
        ]);
        
        // Cập nhật hồ sơ (kỹ năng, kinh nghiệm, học vấn)
        if (isset($data['ky_nang']) || isset($data['kinh_nghiem']) || isset($data['hoc_van'])) {
            $this->updateProfile($id, $data);
        }
        
        return $result;
    }
    
    // Lấy hồ sơ của ứng viên
    public function getProfile($applicantId) {
        $sql = "SELECT * FROM HOSO WHERE ID_UngVien = ?";
        return $this->db->fetchOne($sql, [$applicantId]);
    }
    
    // Tạo hoặc cập nhật hồ sơ
    public function updateProfile($applicantId, $data) {
        // Kiểm tra đã có hồ sơ chưa
        $existing = $this->getProfile($applicantId);
        
        if ($existing) {
            $sql = "UPDATE HOSO SET 
                    KyNang = ?, KinhNghiem = ?, HocVan = ?, 
                    ChungChi = ?, MucTieuNgheNghiep = ?, FileCV = ?
                    WHERE ID_UngVien = ?";
            
            return $this->db->execute($sql, [
                $data['ky_nang'] ?? '',
                $data['kinh_nghiem'] ?? '',
                $data['hoc_van'] ?? '',
                $data['chung_chi'] ?? '',
                $data['muc_tieu'] ?? '',
                $data['file_cv'] ?? $existing['FileCV'],
                $applicantId
            ]);
        } else {
            $id = generateId('HS');
            $sql = "INSERT INTO HOSO (ID_HoSo, ID_UngVien, KyNang, KinhNghiem, HocVan, ChungChi, MucTieuNgheNghiep, FileCV) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            return $this->db->execute($sql, [
                $id,
                $applicantId,
                $data['ky_nang'] ?? '',
                $data['kinh_nghiem'] ?? '',
                $data['hoc_van'] ?? '',
                $data['chung_chi'] ?? '',
                $data['muc_tieu'] ?? '',
                $data['file_cv'] ?? null
            ]);
        }
    }
    
    // Lấy danh sách tất cả ứng viên (cho admin)
    public function getAll($limit = 50, $offset = 0) {
        $sql = "SELECT uv.*, tk.Email, tk.TrangThai 
                FROM UNGVIEN uv
                INNER JOIN TAIKHOAN tk ON uv.ID_TaiKhoan = tk.ID_TaiKhoan
                ORDER BY uv.NgayTao DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }
    
    // Đếm tổng số ứng viên
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM UNGVIEN";
        $result = $this->db->fetchOne($sql);
        return $result['total'];
    }
}
