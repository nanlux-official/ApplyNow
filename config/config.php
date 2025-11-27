<?php
// Cấu hình chung của ứng dụng

// Đường dẫn gốc
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', 'http://localhost:81/ApplyNow/public');

// Đường dẫn assets (CSS, JS, images) - từ document root
define('ASSETS_URL', '/ApplyNow/public');

// Cấu hình session
define('SESSION_LIFETIME', 3600 * 24); // 24 giờ

// Cấu hình email
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'your-email@gmail.com');
define('MAIL_PASSWORD', 'your-password');
define('MAIL_FROM', 'noreply@jobportal.com');
define('MAIL_FROM_NAME', 'Job Portal');

// Cấu hình upload
define('UPLOAD_PATH', BASE_PATH . '/public/uploads');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_CV_TYPES', ['pdf', 'doc', 'docx']);
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Cấu hình phân trang
define('ITEMS_PER_PAGE', 20);

// Múi giờ
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Bật hiển thị lỗi (tắt ở production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
