<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">⚙️ Thông tin công ty</h1>
            <p style="color: #6B7280;">Quản lý thông tin công ty và tài khoản</p>
        </div>
        <a href="<?= BASE_URL ?>/employer/dashboard" class="btn btn-secondary">← Dashboard</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Company Info -->
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 1.25rem; font-weight: 700;">🏢 Thông tin công ty</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>/employer/profile">
                    <div class="form-group">
                        <label>Tên công ty *</label>
                        <input type="text" name="ten" required value="<?= e($employer['Ten']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Email công ty *</label>
                        <input type="email" name="email" required value="<?= e($employer['Email']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="sdt" value="<?= e($employer['SDT']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="trang_web" value="<?= e($employer['TrangWeb']) ?>"
                               placeholder="https://example.com">
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" name="dia_chi" value="<?= e($employer['DiaChi']) ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Quy mô</label>
                            <select name="quy_mo">
                                <option value="">Chọn quy mô</option>
                                <option value="1-50" <?= $employer['QuyMo'] === '1-50' ? 'selected' : '' ?>>1-50 nhân viên</option>
                                <option value="51-200" <?= $employer['QuyMo'] === '51-200' ? 'selected' : '' ?>>51-200 nhân viên</option>
                                <option value="201-500" <?= $employer['QuyMo'] === '201-500' ? 'selected' : '' ?>>201-500 nhân viên</option>
                                <option value="501-1000" <?= $employer['QuyMo'] === '501-1000' ? 'selected' : '' ?>>501-1000 nhân viên</option>
                                <option value="1000+" <?= $employer['QuyMo'] === '1000+' ? 'selected' : '' ?>>Trên 1000 nhân viên</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Lĩnh vực</label>
                            <input type="text" name="linh_vuc" value="<?= e($employer['LinhVuc']) ?>"
                                   placeholder="VD: Công nghệ thông tin">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả công ty</label>
                        <textarea name="mo_ta" rows="5"><?= e($employer['MoTa']) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>

        <!-- Logo Upload -->
        <div class="card" style="margin-top: 0;">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 700;">🖼️ Logo công ty</h3>
            </div>
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <?php if ($employer['Logo']): ?>
                        <img src="<?= ASSETS_URL ?>/uploads/<?= e($employer['Logo']) ?>" 
                             alt="Logo" 
                             style="width: 150px; height: 150px; object-fit: cover; border-radius: 12px; border: 2px solid #E5E7EB;">
                    <?php else: ?>
                        <div style="width: 150px; height: 150px; background: #F3F4F6; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 2px dashed #D1D5DB;">
                            <span style="font-size: 3rem; color: #9CA3AF;">🏢</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <form method="POST" action="<?= BASE_URL ?>/employer/profile/upload-logo" enctype="multipart/form-data">
                    <div class="form-group">
                        <label style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.5rem; display: block;">
                            Chọn logo mới
                        </label>
                        <input type="file" name="logo" accept="image/*" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.875rem;">
                        <small style="color: #9CA3AF; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                            JPG, PNG hoặc GIF. Tối đa 2MB.
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        📤 Upload Logo
                    </button>
                </form>
                
                <div style="border-top: 1px solid #E5E7EB; margin: 1.5rem 0;"></div>
                
                <!-- Change Password Form -->
                <h4 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 1rem;">🔒 Đổi mật khẩu</h4>
                <form method="POST" action="<?= BASE_URL ?>/employer/change-password">
                    <div class="form-group">
                        <label style="font-size: 0.875rem;">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" required>
                    </div>

                    <div class="form-group">
                        <label style="font-size: 0.875rem;">Mật khẩu mới</label>
                        <input type="password" name="new_password" required>
                    </div>

                    <div class="form-group">
                        <label style="font-size: 0.875rem;">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        🔑 Đổi mật khẩu
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div>

        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>