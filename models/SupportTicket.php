<?php
class SupportTicket {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo ticket mới
    public function create($userId, $userType, $data) {
        $id = generateId('TK');
        
        $sql = "INSERT INTO SUPPORT_TICKETS (
                    ID_Ticket, ID_NguoiDung, LoaiNguoiDung, 
                    TieuDe, NoiDung, TrangThai, DoUuTien
                ) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $id,
            $userId,
            $userType,
            $data['tieu_de'],
            $data['noi_dung'],
            'Mới',
            $data['do_uu_tien'] ?? 'Trung bình'
        ]);
        
        return $id;
    }
    
    // Lấy ticket theo ID
    public function findById($id) {
        $sql = "SELECT * FROM SUPPORT_TICKETS WHERE ID_Ticket = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Lấy tickets của user
    public function getByUser($userId, $limit = 20, $offset = 0) {
        $sql = "SELECT * FROM SUPPORT_TICKETS 
                WHERE ID_NguoiDung = ?
                ORDER BY NgayTao DESC
                LIMIT ? OFFSET ?";
        
        return $this->db->fetchAll($sql, [$userId, $limit, $offset]);
    }
    
    // Lấy tất cả tickets (admin)
    public function getAll($filters = [], $limit = 20, $offset = 0) {
        $where = [];
        $params = [];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        if (!empty($filters['do_uu_tien'])) {
            $where[] = "DoUuTien = ?";
            $params[] = $filters['do_uu_tien'];
        }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $sql = "SELECT * FROM SUPPORT_TICKETS 
                {$whereClause}
                ORDER BY 
                    CASE DoUuTien 
                        WHEN 'Khẩn cấp' THEN 1
                        WHEN 'Cao' THEN 2
                        WHEN 'Trung bình' THEN 3
                        WHEN 'Thấp' THEN 4
                    END,
                    NgayTao DESC
                LIMIT ? OFFSET ?";
        
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    // Đếm tickets
    public function count($filters = []) {
        $where = [];
        $params = [];
        
        if (!empty($filters['trang_thai'])) {
            $where[] = "TrangThai = ?";
            $params[] = $filters['trang_thai'];
        }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $sql = "SELECT COUNT(*) as total FROM SUPPORT_TICKETS {$whereClause}";
        $result = $this->db->fetchOne($sql, $params);
        return $result['total'];
    }
    
    // Cập nhật trạng thái
    public function updateStatus($id, $status, $adminId = null, $note = null) {
        $sql = "UPDATE SUPPORT_TICKETS 
                SET TrangThai = ?, NguoiXuLy = ?, GhiChu = ?
                WHERE ID_Ticket = ?";
        
        return $this->db->execute($sql, [$status, $adminId, $note, $id]);
    }
    
    // Thêm reply
    public function addReply($ticketId, $userId, $userType, $content) {
        $id = generateId('RP');
        
        $sql = "INSERT INTO TICKET_REPLIES (
                    ID_Reply, ID_Ticket, ID_NguoiGui, 
                    LoaiNguoiGui, NoiDung
                ) VALUES (?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $id,
            $ticketId,
            $userId,
            $userType,
            $content
        ]);
        
        return $id;
    }
    
    // Lấy replies của ticket
    public function getReplies($ticketId) {
        $sql = "SELECT * FROM TICKET_REPLIES 
                WHERE ID_Ticket = ?
                ORDER BY NgayTao ASC";
        
        return $this->db->fetchAll($sql, [$ticketId]);
    }
    
    // Xóa ticket
    public function delete($id) {
        $sql = "DELETE FROM SUPPORT_TICKETS WHERE ID_Ticket = ?";
        return $this->db->execute($sql, [$id]);
    }
}
