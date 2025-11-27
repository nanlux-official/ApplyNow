<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">👤 Hồ sơ cá nhân</h1>
            <p style="color: #6B7280;">Quản lý thông tin và hồ sơ của bạn</p>
        </div>
        <a href="<?= BASE_URL ?>/applicant/dashboard" class="btn btn-secondary">← Dashboard</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Profile Form -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">📝 Thông tin cá nhân</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/applicant/profile">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Họ lót *</label>
                                <input type="text" name="ho_lot" required value="<?= e($applicant['HoLot']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Tên *</label>
                                <input type="text" name="ten" required value="<?= e($applicant['Ten']) ?>">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" required value="<?= e($applicant['Email']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="sdt" value="<?= e($applicant['SDT']) ?>">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" name="ngay_sinh" value="<?= e($applicant['NgaySinh']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select name="gioi_tinh">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" <?= $applicant['GioiTinh'] === 'Nam' ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?= $applicant['GioiTinh'] === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                                    <option value="Khác" <?= $applicant['GioiTinh'] === 'Khác' ? 'selected' : '' ?>>Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="dia_chi" value="<?= e($applicant['DiaChi']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Kỹ năng</label>
                            <textarea name="ky_nang" rows="4" placeholder="VD: Java, Spring Boot, MySQL, React..."><?= e($applicant['KyNang'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Kinh nghiệm làm việc</label>
                            <textarea name="kinh_nghiem" rows="5" placeholder="Mô tả kinh nghiệm làm việc của bạn..."><?= e($applicant['KinhNghiem'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Học vấn</label>
                            <textarea name="hoc_van" rows="4" placeholder="Trình độ học vấn, bằng cấp..."><?= e($applicant['HocVan'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Change Password -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">🔒 Đổi mật khẩu</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/applicant/change-password">
                        <div class="form-group">
                            <label>Mật khẩu hiện tại</label>
                            <input type="password" name="old_password" required>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label>Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">🔑 Đổi mật khẩu</button>
                    </form>
                </div>
            </div>

            <!-- Profile Tips -->
            <div class="card" style="background: #DBEAFE; border-color: #3B82F6;">
                <div class="card-body">
                    <h4 style="font-weight: 600; color: #1E40AF; margin-bottom: 0.75rem;">💡 Mẹo hoàn thiện hồ sơ</h4>
                    <ul style="color: #1E40AF; font-size: 0.875rem; line-height: 1.8; margin: 0; padding-left: 1.25rem;">
                        <li>Điền đầy đủ thông tin cá nhân</li>
                        <li>Mô tả rõ kỹ năng và kinh nghiệm</li>
                        <li>Cập nhật CV định kỳ</li>
                        <li>Thêm chứng chỉ nếu có</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
