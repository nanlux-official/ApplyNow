<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo tài khoản mới
    public function create($email, $password) {
        $id = generateId('TK');
        $hashedPassword = hashPassword($password);
        $token = bin2hex(random_bytes(32));
        $tokenExpiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $sql = "INSERT INTO TAIKHOAN (ID_TaiKhoan, Email, Pass, TokenXacThuc, TokenExpiry, TrangThai) 
                VALUES (?, ?, ?, ?, ?, 'inactive')";
        
        $this->db->execute($sql, [$id, $email, $hashedPassword, $token, $tokenExpiry]);
        
        return ['id' => $id, 'token' => $token];
    }
    
    // Tìm user theo email
    public function findByEmail($email) {
        $sql = "SELECT * FROM TAIKHOAN WHERE Email = ?";
        return $this->db->fetchOne($sql, [$email]);
    }
    
    // Tìm user theo ID
    public function findById($id) {
        $sql = "SELECT * FROM TAIKHOAN WHERE ID_TaiKhoan = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Xác thực email
    public function verifyEmail($token) {
        $sql = "SELECT * FROM TAIKHOAN WHERE TokenXacThuc = ? AND TokenExpiry > NOW()";
        $user = $this->db->fetchOne($sql, [$token]);
        
        if ($user) {
            $updateSql = "UPDATE TAIKHOAN SET TrangThai = 'active', TokenXacThuc = NULL WHERE ID_TaiKhoan = ?";
            $this->db->execute($updateSql, [$user['ID_TaiKhoan']]);
            return true;
        }
        
        return false;
    }
    
    // Tạo token reset password
    public function createResetToken($email) {
        $user = $this->findByEmail($email);
        if (!$user) return false;
        
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $sql = "UPDATE TAIKHOAN SET TokenResetPass = ?, TokenExpiry = ? WHERE ID_TaiKhoan = ?";
        $this->db->execute($sql, [$token, $expiry, $user['ID_TaiKhoan']]);
        
        return $token;
    }
    
    // Reset mật khẩu
    public function resetPassword($token, $newPassword) {
        $sql = "SELECT * FROM TAIKHOAN WHERE TokenResetPass = ? AND TokenExpiry > NOW()";
        $user = $this->db->fetchOne($sql, [$token]);
        
        if ($user) {
            $hashedPassword = hashPassword($newPassword);
            $updateSql = "UPDATE TAIKHOAN SET Pass = ?, TokenResetPass = NULL WHERE ID_TaiKhoan = ?";
            $this->db->execute($updateSql, [$hashedPassword, $user['ID_TaiKhoan']]);
            return true;
        }
        
        return false;
    }
    
    // Đổi mật khẩu
    public function changePassword($userId, $oldPassword, $newPassword) {
        $user = $this->findById($userId);
        
        if ($user && verifyPassword($oldPassword, $user['Pass'])) {
            $hashedPassword = hashPassword($newPassword);
            $sql = "UPDATE TAIKHOAN SET Pass = ? WHERE ID_TaiKhoan = ?";
            $this->db->execute($sql, [$hashedPassword, $userId]);
            return true;
        }
        
        return false;
    }
    
    // Lấy vai trò của user
    public function getRoles($userId) {
        $sql = "SELECT v.Ten FROM VAITRO v 
                INNER JOIN TAIKHOANVAITRO tv ON v.ID_VaiTro = tv.ID_VaiTro 
                WHERE tv.ID_TaiKhoan = ?";
        
        $roles = $this->db->fetchAll($sql, [$userId]);
        return array_column($roles, 'Ten');
    }
    
    // Gán vai trò cho user
    public function assignRole($userId, $roleName) {
        // Lấy ID vai trò
        $sql = "SELECT ID_VaiTro FROM VAITRO WHERE Ten = ?";
        $role = $this->db->fetchOne($sql, [$roleName]);
        
        if ($role) {
            $id = generateId('TKVT');
            $insertSql = "INSERT INTO TAIKHOANVAITRO (ID, ID_TaiKhoan, ID_VaiTro) VALUES (?, ?, ?)";
            $this->db->execute($insertSql, [$id, $userId, $role['ID_VaiTro']]);
            return true;
        }
        
        return false;
    }
    
    // Cập nhật trạng thái tài khoản
    public function updateStatus($userId, $status) {
        $sql = "UPDATE TAIKHOAN SET TrangThai = ? WHERE ID_TaiKhoan = ?";
        return $this->db->execute($sql, [$status, $userId]);
    }
    
    // Xóa tài khoản
    public function delete($userId) {
        $sql = "DELETE FROM TAIKHOAN WHERE ID_TaiKhoan = ?";
        return $this->db->execute($sql, [$userId]);
    }
    
    // Lấy tất cả users (cho admin)
    public function getAll($limit = 50, $offset = 0) {
        $sql = "SELECT t.*, GROUP_CONCAT(v.Ten) as roles 
                FROM TAIKHOAN t
                LEFT JOIN TAIKHOANVAITRO tv ON t.ID_TaiKhoan = tv.ID_TaiKhoan
                LEFT JOIN VAITRO v ON tv.ID_VaiTro = v.ID_VaiTro
                GROUP BY t.ID_TaiKhoan
                ORDER BY t.NgayTao DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }
    
    // Đếm tổng số users
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM TAIKHOAN";
        $result = $this->db->fetchOne($sql);
        return $result['total'];
    }
    
    // Lấy ID vai trò theo tên
    public function getRoleIdByName($roleName) {
        $sql = "SELECT ID_VaiTro FROM vaitro WHERE Ten = ?";
        $result = $this->db->fetchOne($sql, [$roleName]);
        return $result ? $result['ID_VaiTro'] : null;
    }
    
    // Lấy danh sách vai trò của user
    public function getUserRoles($userId) {
        $sql = "SELECT v.Ten 
                FROM taikhoanvaitro tv
                JOIN vaitro v ON tv.ID_VaiTro = v.ID_VaiTro
                WHERE tv.ID_TaiKhoan = ?";
        $results = $this->db->fetchAll($sql, [$userId]);
        return array_column($results, 'Ten');
    }
}
