<?php
// Hàm gửi email

function sendEmail($to, $subject, $body, $isHtml = true) {
    // Sử dụng PHPMailer hoặc mail() function
    // Đây là version đơn giản với mail()
    
    $headers = [];
    $headers[] = 'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM . '>';
    $headers[] = 'Reply-To: ' . MAIL_FROM;
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    
    if ($isHtml) {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
    }
    
    $success = mail($to, $subject, $body, implode("\r\n", $headers));
    
    if (!$success) {
        error_log("Failed to send email to: " . $to);
    }
    
    return $success;
}

// Gửi email xác thực tài khoản
function sendVerificationEmail($email, $token) {
    $verifyUrl = BASE_URL . '/verify-email?token=' . $token;
    
    $subject = 'Xác thực tài khoản Job Portal';
    $body = "
    <html>
    <body>
        <h2>Chào mừng bạn đến với Job Portal!</h2>
        <p>Vui lòng click vào link bên dưới để xác thực tài khoản của bạn:</p>
        <p><a href='{$verifyUrl}'>Xác thực tài khoản</a></p>
        <p>Hoặc copy link sau vào trình duyệt:</p>
        <p>{$verifyUrl}</p>
        <p>Link này sẽ hết hạn sau 24 giờ.</p>
        <br>
        <p>Trân trọng,<br>Job Portal Team</p>
    </body>
    </html>
    ";
    
    return sendEmail($email, $subject, $body);
}

// Gửi email reset mật khẩu
function sendResetPasswordEmail($email, $token) {
    $resetUrl = BASE_URL . '/reset-password?token=' . $token;
    
    $subject = 'Đặt lại mật khẩu Job Portal';
    $body = "
    <html>
    <body>
        <h2>Yêu cầu đặt lại mật khẩu</h2>
        <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
        <p>Vui lòng click vào link bên dưới để đặt lại mật khẩu:</p>
        <p><a href='{$resetUrl}'>Đặt lại mật khẩu</a></p>
        <p>Hoặc copy link sau vào trình duyệt:</p>
        <p>{$resetUrl}</p>
        <p>Link này sẽ hết hạn sau 1 giờ.</p>
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
        <br>
        <p>Trân trọng,<br>Job Portal Team</p>
    </body>
    </html>
    ";
    
    return sendEmail($email, $subject, $body);
}

// Gửi thông báo cho ứng viên
function sendNotificationEmail($email, $subject, $message) {
    $body = "
    <html>
    <body>
        <h2>{$subject}</h2>
        <p>{$message}</p>
        <br>
        <p>Đăng nhập vào hệ thống để xem chi tiết: <a href='" . BASE_URL . "'>Job Portal</a></p>
        <br>
        <p>Trân trọng,<br>Job Portal Team</p>
    </body>
    </html>
    ";
    
    return sendEmail($email, $subject, $body);
}
