<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="auth-container">
        <div class="auth-box">
            <h2>Đăng ký tài khoản</h2>
            
            <form method="POST" action="<?= BASE_URL ?>/register" class="auth-form">
                <div class="form-group">
                    <label>Loại tài khoản</label>
                    <select name="loai_tai_khoan" required>
                        <option value="applicant">Ứng viên tìm việc</option>
                        <option value="employer">Nhà tuyển dụng</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="ho_ten" required 
                           value="<?= e(getFlash('old')['ho_ten'] ?? '') ?>">
                    <?php if (hasFlash('errors') && isset(getFlash('errors')['ho_ten'])): ?>
                        <span class="error"><?= e(getFlash('errors')['ho_ten'][0]) ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required 
                           value="<?= e(getFlash('old')['email'] ?? '') ?>">
                    <?php if (hasFlash('errors') && isset(getFlash('errors')['email'])): ?>
                        <span class="error"><?= e(getFlash('errors')['email'][0]) ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required>
                    <?php if (hasFlash('errors') && isset(getFlash('errors')['password'])): ?>
                        <span class="error"><?= e(getFlash('errors')['password'][0]) ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            </form>
            
            <p class="auth-footer">
                Đã có tài khoản? <a href="<?= BASE_URL ?>/login">Đăng nhập ngay</a>
            </p>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
