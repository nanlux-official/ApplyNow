<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="auth-container">
        <div class="auth-box">
            <h2>Đặt lại mật khẩu</h2>
            
            <form method="POST" action="<?= BASE_URL ?>/reset-password" class="auth-form">
                <input type="hidden" name="token" value="<?= e($token) ?>">
                
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="password" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
