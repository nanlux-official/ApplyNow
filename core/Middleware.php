<?php
class Middleware {
    
    // Kiểm tra đã đăng nhập
    public static function auth() {
        if (!isset($_SESSION['user_id'])) {
            if (self::isAjaxRequest()) {
                http_response_code(401);
                echo json_encode(['error' => 'Vui lòng đăng nhập']);
                exit;
            } else {
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
        }
    }
    
    // Kiểm tra vai trò
    public static function role($requiredRole) {
        self::auth();
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $requiredRole) {
            if (self::isAjaxRequest()) {
                http_response_code(403);
                echo json_encode(['error' => 'Bạn không có quyền truy cập']);
                exit;
            } else {
                http_response_code(403);
                die('Bạn không có quyền truy cập trang này');
            }
        }
    }
    
    // Kiểm tra là ứng viên
    public static function applicant() {
        self::role('APPLICANT');
    }
    
    // Kiểm tra là nhà tuyển dụng
    public static function employer() {
        self::role('EMPLOYER');
    }
    
    // Kiểm tra là admin
    public static function admin() {
        self::role('ADMIN');
    }
    
    // Kiểm tra chưa đăng nhập (cho trang login/register)
    public static function guest() {
        if (isset($_SESSION['user_id'])) {
            $role = $_SESSION['user_role'] ?? 'APPLICANT';
            
            switch ($role) {
                case 'ADMIN':
                    header('Location: ' . BASE_URL . '/admin/dashboard');
                    break;
                case 'EMPLOYER':
                    header('Location: ' . BASE_URL . '/employer/dashboard');
                    break;
                default:
                    header('Location: ' . BASE_URL . '/applicant/dashboard');
            }
            exit;
        }
    }
    
    // Kiểm tra CSRF token
    public static function csrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            
            if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
                http_response_code(403);
                die('CSRF token không hợp lệ');
            }
        }
    }
    
    // Tạo CSRF token
    public static function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    // Kiểm tra request AJAX
    private static function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
