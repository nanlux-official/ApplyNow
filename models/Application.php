<?php
class Application {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo đơn ứng tuyển
    public function create($jobId, $applicantId, $data) {
        // Kiểm tra đã ứng tuyển chưa
        if ($this->hasApplied($jobId, $applicantId)) {
            return false;
        }
        
        $id = generateId('DUT');
        
        $sql = "INSERT INTO DONUNGTUYEN (ID_DonUngTuyen, ID_BaiDang, ID_UngVien, FileCV, ThuXinViec, TrangThai) 
                VALUES (?, ?, ?, ?, ?, 'Mới nộp')";
        
        $this->db->execute($sql, [
            $id,
            $jobId,
            $applicantId,
            $data['file_cv'] ?? null,
            $data['thu_xin_viec'] ?? ''
        ]);
        
        return $id;
    }
    
    // Kiểm tra đã ứng tuyển chưa
    public function hasApplied($jobId, $applicantId) {
        $sql = "SELECT COUNT(*) as count FROM DONUNGTUYEN 
                WHERE ID_BaiDang = ? AND ID_UngVien = ?";
        $result = $this->db->fetchOne($sql, [$jobId, $applicantId]);
        return $result['count'] > 0;
    }
    
    // Lấy đơn ứng tuyển theo ID
    public function findById($id) {
        $sql = "SELECT dut.*, 
                bd.TieuDe, bd.DiaDiem, bd.MucLuong, bd.ID_NhaTuyenDung,
                ntd.Ten as ten_cong_ty, ntd.Logo,
                uv.HoLot, uv.Ten as ten_ungvien, uv.SDT, uv.Email, uv.DiaChi,
                hs.KyNang, hs.KinhNghiem, hs.HocVan
                FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                INNER JOIN UNGVIEN uv ON dut.ID_UngVien = uv.ID_UngVien
                LEFT JOIN HOSO hs ON uv.ID_UngVien = hs.ID_UngVien
                WHERE dut.ID_DonUngTuyen = ?";
        
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Cập nhật trạng thái đơn ứng tuyển
    public function updateStatus($id, $status) {
        $sql = "UPDATE DONUNGTUYEN SET TrangThai = ? WHERE ID_DonUngTuyen = ?";
        return $this->db->execute($sql, [$status, $id]);
    }
    
    // Lấy đơn ứng tuyển của ứng viên
    public function getByApplicant($applicantId, $filters = [], $limit = 20, $offset = 0) {
        $where = ["dut.ID_UngVien = ?"];
        $params = [$applicantId];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "dut.TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT dut.*, 
                bd.TieuDe, bd.DiaDiem, bd.MucLuong, bd.TrangThai as trang_thai_job,
                ntd.Ten as ten_cong_ty, ntd.Logo
                FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE {$whereClause}
                ORDER BY dut.NgayUngTuyen DESC
                LIMIT ? OFFSET ?";
        
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    // Đếm đơn ứng tuyển của ứng viên
    public function countByApplicant($applicantId, $filters = []) {
        $where = ["dut.ID_UngVien = ?"];
        $params = [$applicantId];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "dut.TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT COUNT(*) as total FROM DONUNGTUYEN dut WHERE {$whereClause}";
        $result = $this->db->fetchOne($sql, $params);
        return $result['total'];
    }
    
    // Lấy đơn ứng tuyển theo công việc
    public function getByJob($jobId, $filters = [], $limit = 20, $offset = 0) {
        $where = ["dut.ID_BaiDang = ?"];
        $params = [$jobId];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "dut.TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT dut.*, 
                uv.HoLot, uv.Ten as ten_ungvien, uv.SDT, uv.Email, uv.AnhDaiDien,
                hs.KyNang, hs.KinhNghiem, hs.HocVan
                FROM DONUNGTUYEN dut
                INNER JOIN UNGVIEN uv ON dut.ID_UngVien = uv.ID_UngVien
                LEFT JOIN HOSO hs ON uv.ID_UngVien = hs.ID_UngVien
                WHERE {$whereClause}
                ORDER BY dut.NgayUngTuyen DESC
                LIMIT ? OFFSET ?";
        
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    // Đếm đơn ứng tuyển theo công việc
    public function countByJob($jobId, $filters = []) {
        $where = ["dut.ID_BaiDang = ?"];
        $params = [$jobId];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "dut.TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT COUNT(*) as total FROM DONUNGTUYEN dut WHERE {$whereClause}";
        $result = $this->db->fetchOne($sql, $params);
        return $result['total'];
    }
    
    // Lấy đơn ứng tuyển theo nhà tuyển dụng
    public function getByEmployer($employerId, $filters = [], $limit = 20, $offset = 0) {
        $where = ["bd.ID_NhaTuyenDung = ?"];
        $params = [$employerId];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "dut.TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        if (!empty($filters['job_id'])) {
            $where[] = "dut.ID_BaiDang = ?";
            $params[] = $filters['job_id'];
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT dut.*, 
                bd.TieuDe, bd.DiaDiem,
                uv.HoLot, uv.Ten as ten_ungvien, uv.SDT, uv.Email, uv.AnhDaiDien
                FROM DONUNGTUYEN dut
                INNER JOIN BAIDANG bd ON dut.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN UNGVIEN uv ON dut.ID_UngVien = uv.ID_UngVien
                WHERE {$whereClause}
                ORDER BY dut.NgayUngTuyen DESC
                LIMIT ? OFFSET ?";
        
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    // Xóa đơn ứng tuyển
    public function delete($id) {
        $sql = "DELETE FROM DONUNGTUYEN WHERE ID_DonUngTuyen = ?";
        return $this->db->execute($sql, [$id]);
    }
}
