<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="auth-container">
        <div class="auth-box">
            <h2>Đăng nhập</h2>
            
            <form method="POST" action="<?= BASE_URL ?>/login" class="auth-form">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label class="checkbox">
                        <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </form>
            
            <p class="auth-footer">
                <a href="<?= BASE_URL ?>/forgot-password">Quên mật khẩu?</a>
            </p>
            
            <p class="auth-footer">
                Chưa có tài khoản? <a href="<?= BASE_URL ?>/register">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
