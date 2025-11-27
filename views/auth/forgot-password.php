<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="auth-container">
        <div class="auth-box">
            <h2>Quên mật khẩu</h2>
            <p>Nhập email của bạn để nhận link đặt lại mật khẩu</p>
            
            <form method="POST" action="<?= BASE_URL ?>/forgot-password" class="auth-form">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required autofocus>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Gửi link đặt lại</button>
            </form>
            
            <p class="auth-footer">
                <a href="<?= BASE_URL ?>/login">Quay lại đăng nhập</a>
            </p>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
