<?php
class Job {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo bài đăng mới
    public function create($employerId, $data) {
        $id = generateId('BD');
        
        $sql = "INSERT INTO BAIDANG (
                    ID_BaiDang, TieuDe, MoTa, YeuCau, MucLuong, MucLuongMax, 
                    LoaiLuong, DiaDiem, ID_NhaTuyenDung, LoaiCongViec, 
                    CapBac, KinhNghiem, SoLuong, NgayHetHan, TrangThai
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')";
        
        $this->db->execute($sql, [
            $id,
            $data['tieu_de'],
            $data['mo_ta'] ?? '',
            $data['yeu_cau'] ?? '',
            $data['muc_luong'] ?? null,
            $data['muc_luong_max'] ?? null,
            $data['loai_luong'] ?? 'Thỏa thuận',
            $data['dia_diem'],
            $employerId,
            $data['loai_cong_viec'] ?? 'Full-time',
            $data['cap_bac'] ?? '',
            $data['kinh_nghiem'] ?? '',
            $data['so_luong'] ?? 1,
            $data['ngay_het_han'] ?? null
        ]);
        
        return $id;
    }
    
    // Lấy bài đăng theo ID
    public function findById($id) {
        $sql = "SELECT bd.*, ntd.Ten as ten_cong_ty, ntd.Logo, ntd.DiaChi as dia_chi_cong_ty,
                ntd.QuyMo, ntd.LinhVuc
                FROM BAIDANG bd
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE bd.ID_BaiDang = ?";
        
        $job = $this->db->fetchOne($sql, [$id]);
        
        // Tăng lượt xem
        if ($job) {
            $this->incrementViews($id);
        }
        
        return $job;
    }
    
    // Cập nhật bài đăng
    public function update($id, $data) {
        $sql = "UPDATE BAIDANG SET 
                TieuDe = ?, MoTa = ?, YeuCau = ?, MucLuong = ?, MucLuongMax = ?,
                LoaiLuong = ?, DiaDiem = ?, LoaiCongViec = ?, CapBac = ?,
                KinhNghiem = ?, SoLuong = ?, NgayHetHan = ?
                WHERE ID_BaiDang = ?";
        
        return $this->db->execute($sql, [
            $data['tieu_de'],
            $data['mo_ta'] ?? '',
            $data['yeu_cau'] ?? '',
            $data['muc_luong'] ?? null,
            $data['muc_luong_max'] ?? null,
            $data['loai_luong'] ?? 'Thỏa thuận',
            $data['dia_diem'],
            $data['loai_cong_viec'] ?? 'Full-time',
            $data['cap_bac'] ?? '',
            $data['kinh_nghiem'] ?? '',
            $data['so_luong'] ?? 1,
            $data['ngay_het_han'] ?? null,
            $id
        ]);
    }
    
    // Xóa bài đăng
    public function delete($id) {
        $sql = "DELETE FROM BAIDANG WHERE ID_BaiDang = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    // Cập nhật trạng thái
    public function updateStatus($id, $status) {
        $sql = "UPDATE BAIDANG SET TrangThai = ? WHERE ID_BaiDang = ?";
        return $this->db->execute($sql, [$status, $id]);
    }
    
    // Tăng lượt xem
    private function incrementViews($id) {
        $sql = "UPDATE BAIDANG SET LuotXem = LuotXem + 1 WHERE ID_BaiDang = ?";
        $this->db->execute($sql, [$id]);
    }
    
    // Tìm kiếm và lọc công việc
    public function search($filters = [], $limit = 20, $offset = 0) {
        $where = ["bd.TrangThai = 'active'"];
        $params = [];
        
        // Từ khóa
        if (!empty($filters['keyword'])) {
            $where[] = "(bd.TieuDe LIKE ? OR bd.MoTa LIKE ? OR ntd.Ten LIKE ?)";
            $keyword = '%' . $filters['keyword'] . '%';
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }
        
        // Địa điểm
        if (!empty($filters['dia_diem'])) {
            $where[] = "bd.DiaDiem LIKE ?";
            $params[] = '%' . $filters['dia_diem'] . '%';
        }
        
        // Loại công việc
        if (!empty($filters['loai_cong_viec'])) {
            $where[] = "bd.LoaiCongViec = ?";
            $params[] = $filters['loai_cong_viec'];
        }
        
        // Kinh nghiệm
        if (!empty($filters['kinh_nghiem'])) {
            $where[] = "bd.KinhNghiem LIKE ?";
            $params[] = '%' . $filters['kinh_nghiem'] . '%';
        }
        
        // Mức lương
        if (!empty($filters['muc_luong_min'])) {
            $where[] = "bd.MucLuong >= ?";
            $params[] = $filters['muc_luong_min'];
        }
        
        if (!empty($filters['muc_luong_max'])) {
            $where[] = "bd.MucLuong <= ?";
            $params[] = $filters['muc_luong_max'];
        }
        
        // Lĩnh vực
        if (!empty($filters['linh_vuc'])) {
            $where[] = "ntd.LinhVuc LIKE ?";
            $params[] = '%' . $filters['linh_vuc'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        // Sắp xếp
        $orderBy = "bd.NgayDangTin DESC";
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'salary_desc':
                    $orderBy = "bd.MucLuong DESC";
                    break;
                case 'views_desc':
                    $orderBy = "bd.LuotXem DESC";
                    break;
            }
        }
        
        $sql = "SELECT bd.*, ntd.Ten as ten_cong_ty, ntd.Logo, ntd.DiaChi as dia_chi_cong_ty
                FROM BAIDANG bd
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE {$whereClause}
                ORDER BY {$orderBy}
                LIMIT ? OFFSET ?";
        
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    // Đếm kết quả tìm kiếm
    public function countSearch($filters = []) {
        $where = ["bd.TrangThai = 'active'"];
        $params = [];
        
        if (!empty($filters['keyword'])) {
            $where[] = "(bd.TieuDe LIKE ? OR bd.MoTa LIKE ? OR ntd.Ten LIKE ?)";
            $keyword = '%' . $filters['keyword'] . '%';
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }
        
        if (!empty($filters['dia_diem'])) {
            $where[] = "bd.DiaDiem LIKE ?";
            $params[] = '%' . $filters['dia_diem'] . '%';
        }
        
        if (!empty($filters['loai_cong_viec'])) {
            $where[] = "bd.LoaiCongViec = ?";
            $params[] = $filters['loai_cong_viec'];
        }
        
        if (!empty($filters['kinh_nghiem'])) {
            $where[] = "bd.KinhNghiem LIKE ?";
            $params[] = '%' . $filters['kinh_nghiem'] . '%';
        }
        
        if (!empty($filters['linh_vuc'])) {
            $where[] = "ntd.LinhVuc LIKE ?";
            $params[] = '%' . $filters['linh_vuc'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT COUNT(*) as total FROM BAIDANG bd
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE {$whereClause}";
        
        $result = $this->db->fetchOne($sql, $params);
        return $result['total'];
    }
    
    // Lấy công việc của nhà tuyển dụng
    public function getByEmployer($employerId, $limit = 20, $offset = 0) {
        $sql = "SELECT bd.*, 
                (SELECT COUNT(*) FROM DONUNGTUYEN WHERE ID_BaiDang = bd.ID_BaiDang) as so_ung_tuyen
                FROM BAIDANG bd
                WHERE bd.ID_NhaTuyenDung = ?
                ORDER BY bd.NgayDangTin DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$employerId, $limit, $offset]);
    }
    
    // Lấy công việc mới nhất
    public function getLatest($limit = 10) {
        $sql = "SELECT bd.*, ntd.Ten as ten_cong_ty, ntd.Logo
                FROM BAIDANG bd
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE bd.TrangThai = 'active' AND bd.NgayHetHan > NOW()
                ORDER BY bd.NgayDangTin DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Lấy công việc gợi ý cho ứng viên
    public function getRecommended($applicantId, $limit = 10) {
        // Lấy công việc phù hợp, loại trừ đã ứng tuyển
        $sql = "SELECT bd.*, ntd.Ten as ten_cong_ty, ntd.Logo
                FROM BAIDANG bd
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE bd.TrangThai = 'Đang hoạt động'
                AND bd.NgayHetHan >= CURDATE()
                AND bd.ID_BaiDang NOT IN (
                    SELECT ID_BaiDang FROM DONUNGTUYEN WHERE ID_UngVien = ?
                )
                ORDER BY bd.NgayDangTin DESC, bd.LuotXem DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$applicantId, $limit]);
    }
    
    // Lấy tất cả công việc (cho admin)
    public function getAll($limit = 50, $offset = 0) {
        $sql = "SELECT bd.*, ntd.Ten as ten_cong_ty,
                (SELECT COUNT(*) FROM DONUNGTUYEN WHERE ID_BaiDang = bd.ID_BaiDang) as so_ung_tuyen
                FROM BAIDANG bd
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                ORDER BY bd.NgayDangTin DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }
    
    // Đếm tổng số công việc
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM BAIDANG";
        $result = $this->db->fetchOne($sql);
        return $result['total'];
    }
}
