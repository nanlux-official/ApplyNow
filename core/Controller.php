<?php
class Controller {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    protected function view($viewPath, $data = []) {
        extract($data);
        $viewFile = BASE_PATH . '/views/' . $viewPath . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View không tồn tại: " . $viewPath);
        }
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
    
    protected function back() {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    protected function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'],
                'role' => $_SESSION['user_role'] ?? null
            ];
        }
        return null;
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function hasRole($role) {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
    }
}
