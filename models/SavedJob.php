<?php
class SavedJob {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Lưu công việc
    public function save($applicantId, $jobId) {
        // Kiểm tra đã lưu chưa
        if ($this->isSaved($applicantId, $jobId)) {
            return false;
        }
        
        $id = generateId('LCV');
        
        $sql = "INSERT INTO LUUBAIDANG (ID_LuuCongViec, ID_UngVien, ID_BaiDang) 
                VALUES (?, ?, ?)";
        
        $this->db->execute($sql, [$id, $applicantId, $jobId]);
        return true;
    }
    
    // Bỏ lưu công việc
    public function unsave($applicantId, $jobId) {
        $sql = "DELETE FROM LUUBAIDANG WHERE ID_UngVien = ? AND ID_BaiDang = ?";
        return $this->db->execute($sql, [$applicantId, $jobId]);
    }
    
    // Kiểm tra đã lưu chưa
    public function isSaved($applicantId, $jobId) {
        $sql = "SELECT COUNT(*) as count FROM LUUBAIDANG 
                WHERE ID_UngVien = ? AND ID_BaiDang = ?";
        $result = $this->db->fetchOne($sql, [$applicantId, $jobId]);
        return $result['count'] > 0;
    }
    
    // Lấy danh sách công việc đã lưu
    public function getSavedJobs($applicantId, $limit = 20, $offset = 0) {
        $sql = "SELECT lcv.*, bd.*, ntd.Ten as ten_cong_ty, ntd.Logo
                FROM LUUBAIDANG lcv
                INNER JOIN BAIDANG bd ON lcv.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE lcv.ID_UngVien = ?
                ORDER BY lcv.NgayLuu DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$applicantId, $limit, $offset]);
    }
    
    // Đếm số công việc đã lưu
    public function count($applicantId) {
        $sql = "SELECT COUNT(*) as total FROM LUUBAIDANG WHERE ID_UngVien = ?";
        $result = $this->db->fetchOne($sql, [$applicantId]);
        return $result['total'];
    }
    
    // Toggle lưu/bỏ lưu
    public function toggle($jobId, $applicantId) {
        if ($this->isSaved($applicantId, $jobId)) {
            return $this->unsave($applicantId, $jobId);
        } else {
            return $this->save($applicantId, $jobId);
        }
    }
    
    // Alias cho getSavedJobs
    public function getByApplicant($applicantId, $limit = 20, $offset = 0) {
        $sql = "SELECT lcv.*, bd.*, ntd.Ten as ten_cong_ty, ntd.Logo,
                EXISTS(SELECT 1 FROM DONUNGTUYEN WHERE ID_BaiDang = bd.ID_BaiDang AND ID_UngVien = ?) as da_ung_tuyen
                FROM LUUBAIDANG lcv
                INNER JOIN BAIDANG bd ON lcv.ID_BaiDang = bd.ID_BaiDang
                INNER JOIN NHATUYENDUNG ntd ON bd.ID_NhaTuyenDung = ntd.ID_NhaTuyenDung
                WHERE lcv.ID_UngVien = ?
                ORDER BY lcv.NgayLuu DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$applicantId, $applicantId, $limit, $offset]);
    }
    
    // Alias cho count
    public function countByApplicant($applicantId) {
        return $this->count($applicantId);
    }
}
