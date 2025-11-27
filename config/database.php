<?php
// Cấu hình kết nối database
// Hỗ trợ cả local development và cloud deployment (Render.com)

if (getenv('DATABASE_URL')) {
    // Cloud deployment (Render.com, Heroku, Railway, etc.)
    $db_url = parse_url(getenv('DATABASE_URL'));
    define('DB_HOST', $db_url['host']);
    define('DB_USER', $db_url['user']);
    define('DB_PASS', $db_url['pass'] ?? '');
    define('DB_NAME', ltrim($db_url['path'], '/'));
    define('DB_PORT', $db_url['port'] ?? 3306);
} else {
    // Local development
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'job_portal');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_PORT', 3306);
}
define('DB_CHARSET', 'utf8mb4');

// Tùy chọn PDO
define('PDO_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);
