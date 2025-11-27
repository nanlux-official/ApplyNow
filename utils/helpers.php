<?php
// Các hàm hỗ trợ chung

// Tạo đường dẫn asset (CSS, JS, images)
function asset($path) {
    // Loại bỏ dấu / ở đầu nếu có
    $path = ltrim($path, '/');
    return ASSETS_URL . '/' . $path;
}

// Tạo URL cho routes (không bao gồm /public)
function url($path = '') {
    // Loại bỏ dấu / ở đầu nếu có
    $path = ltrim($path, '/');
    // BASE_URL đã có /public, nên chỉ cần thêm path
    return BASE_URL . ($path ? '/' . $path : '');
}

// Tạo ID ngẫu nhiên
function generateId($prefix = '') {
    return $prefix . strtoupper(uniqid());
}

// Hash mật khẩu
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Kiểm tra mật khẩu
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Escape HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Format ngày tháng
function formatDate($date, $format = 'd/m/Y') {
    if (empty($date)) return '';
    return date($format, strtotime($date));
}

// Format ngày giờ
function formatDateTime($datetime, $format = 'd/m/Y H:i') {
    if (empty($datetime)) return '';
    return date($format, strtotime($datetime));
}

// Format tiền tệ
function formatMoney($amount) {
    if (empty($amount)) return 'Thỏa thuận';
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

// Tính thời gian đã qua
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return $diff . ' giây trước';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' phút trước';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' giờ trước';
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . ' ngày trước';
    } else {
        return formatDate($datetime);
    }
}

// Cắt chuỗi
function truncate($string, $length = 100, $append = '...') {
    if (mb_strlen($string) <= $length) {
        return $string;
    }
    return mb_substr($string, 0, $length) . $append;
}

// Tạo slug từ tiêu đề
function createSlug($string) {
    $string = mb_strtolower($string);
    $string = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $string);
    $string = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $string);
    $string = preg_replace('/[íìỉĩị]/u', 'i', $string);
    $string = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $string);
    $string = preg_replace('/[úùủũụưứừửữự]/u', 'u', $string);
    $string = preg_replace('/[ýỳỷỹỵ]/u', 'y', $string);
    $string = preg_replace('/đ/u', 'd', $string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    return trim($string, '-');
}

// Upload file
function uploadFile($file, $directory, $allowedTypes = []) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Lỗi upload file'];
    }
    
    // Kiểm tra kích thước
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File quá lớn (tối đa 5MB)'];
    }
    
    // Kiểm tra loại file
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!empty($allowedTypes) && !in_array($extension, $allowedTypes)) {
        return ['success' => false, 'message' => 'Loại file không được phép'];
    }
    
    // Tạo tên file mới
    $newFileName = uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = UPLOAD_PATH . '/' . $directory;
    
    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }
    
    $destination = $uploadPath . '/' . $newFileName;
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return [
            'success' => true,
            'filename' => $newFileName,
            'path' => $directory . '/' . $newFileName
        ];
    }
    
    return ['success' => false, 'message' => 'Không thể lưu file'];
}

// Xóa file
function deleteFile($path) {
    $fullPath = UPLOAD_PATH . '/' . $path;
    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}

// Flash message
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

function hasFlash($key) {
    return isset($_SESSION['flash'][$key]);
}

// Redirect với message
function redirectWithMessage($url, $type, $message) {
    setFlash($type, $message);
    header('Location: ' . BASE_URL . $url);
    exit;
}

// Lấy input từ request
function input($key, $default = null) {
    if (isset($_POST[$key])) {
        return trim($_POST[$key]);
    } elseif (isset($_GET[$key])) {
        return trim($_GET[$key]);
    }
    return $default;
}

// Kiểm tra request method
function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function isGet() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

// Sanitize input
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Tạo pagination
function paginate($totalItems, $currentPage, $itemsPerPage = ITEMS_PER_PAGE) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $itemsPerPage;
    
    return [
        'total_items' => $totalItems,
        'total_pages' => $totalPages,
        'current_page' => $currentPage,
        'items_per_page' => $itemsPerPage,
        'offset' => $offset,
        'has_prev' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages
    ];
}

// Format salary
function formatSalary($min, $max = null, $type = 'Thỏa thuận') {
    if (empty($min) || $type === 'Thỏa thuận') {
        return 'Thỏa thuận';
    }
    
    $minFormatted = number_format($min, 0, ',', '.') . ' VNĐ';
    
    if (!empty($max) && $max > $min) {
        $maxFormatted = number_format($max, 0, ',', '.') . ' VNĐ';
        return $minFormatted . ' - ' . $maxFormatted;
    }
    
    return $minFormatted;
}

// Get status badge color
function getStatusBadge($status) {
    $badges = [
        'Mới nộp' => 'primary',
        'Đã xem' => 'info',
        'Mời phỏng vấn' => 'warning',
        'Từ chối' => 'error',
        'Trúng tuyển' => 'success',
        'Đang hoạt động' => 'success',
        'Đã đóng' => 'error',
        'Hết hạn' => 'error'
    ];
    
    return $badges[$status] ?? 'primary';
}

// Get notification icon
function getNotificationIcon($type) {
    $icons = [
        'Ứng tuyển' => '📝',
        'Phỏng vấn' => '📞',
        'Kết quả' => '✉️',
        'Hệ thống' => '🔔',
        'Tin tuyển dụng' => '💼'
    ];
    
    return $icons[$type] ?? '🔔';
}

// Get notification color
function getNotificationColor($type) {
    $colors = [
        'Ứng tuyển' => '#DBEAFE',
        'Phỏng vấn' => '#FEF3C7',
        'Kết quả' => '#D1FAE5',
        'Hệ thống' => '#E0E7FF',
        'Tin tuyển dụng' => '#FCE7F3'
    ];
    
    return $colors[$type] ?? '#F3F4F6';
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Get current user
function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

// Check user role
function hasRole($role) {
    $user = getCurrentUser();
    return $user && $user['role'] === $role;
}
