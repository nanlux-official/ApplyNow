<?php
class AdminLog {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Ghi log quản lý bài đăng
    public function logJobAction($jobId, $employerId, $adminId, $action, $reason = '') {
        $id = generateId('QL');
        
        $sql = "INSERT INTO QUANLYBAIDANG (ID_QuanLy, ID_BaiDang, ID_NhaTuyenDung, ID_Admin, HanhDong, LyDo) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        return $this->db->execute($sql, [$id, $jobId, $employerId, $adminId, $action, $reason]);
    }
    
    // Lấy log của bài đăng
    public function getJobLogs($jobId, $limit = 20) {
        $sql = "SELECT ql.*, tk.Email as admin_email
                FROM QUANLYBAIDANG ql
                LEFT JOIN TAIKHOAN tk ON ql.ID_Admin = tk.ID_TaiKhoan
                WHERE ql.ID_BaiDang = ?
                ORDER BY ql.ThoiGian DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$jobId, $limit]);
    }
    
    // Ghi log quản lý tài khoản
    public function logAccountAction($userId, $userType, $action, $adminId, $info = '') {
        $id = generateId('QLTK');
        
        $sql = "INSERT INTO QUANLYTAIKHOANCANHAN (ID_QuanLyTaiKhoan, ID_TaiKhoan, LoaiNguoiDung, HanhDong, ThongTinTaiKhoan, NguoiCapNhat) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        return $this->db->execute($sql, [$id, $userId, $userType, $action, $info, $adminId]);
    }
    
    // Lấy log của tài khoản
    public function getAccountLogs($userId, $limit = 20) {
        $sql = "SELECT * FROM QUANLYTAIKHOANCANHAN 
                WHERE ID_TaiKhoan = ?
                ORDER BY NgayCapNhat DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$userId, $limit]);
    }
    
    // Lấy tất cả log gần đây
    public function getRecentLogs($limit = 50) {
        $sql = "SELECT 'job' as type, ID_QuanLy as id, HanhDong as action, ThoiGian as time, ID_Admin as admin_id
                FROM QUANLYBAIDANG
                UNION ALL
                SELECT 'account' as type, ID_QuanLyTaiKhoan as id, HanhDong as action, NgayCapNhat as time, NguoiCapNhat as admin_id
                FROM QUANLYTAIKHOANCANHAN
                ORDER BY time DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$limit]);
    }
}
