<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Chỉnh sửa người dùng</h1>
            <p style="color: #6B7280;">Cập nhật thông tin tài khoản</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Edit Form -->
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 1.25rem; font-weight: 700;">Thông tin tài khoản</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/update">
                    <div class="form-group">
                        <label>ID Tài khoản</label>
                        <input type="text" value="<?= e($user['ID_TaiKhoan']) ?>" disabled
                               style="background: #F3F4F6; cursor: not-allowed; font-family: monospace;">
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required 
                               value="<?= e($user['Email']) ?>">
                        <small style="color: #6B7280; font-size: 0.875rem;">Email dùng để đăng nhập</small>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái *</label>
                        <select name="trang_thai" required>
                            <option value="active" <?= $user['TrangThai'] === 'active' ? 'selected' : '' ?>>Active - Hoạt động</option>
                            <option value="inactive" <?= $user['TrangThai'] === 'inactive' ? 'selected' : '' ?>>Inactive - Chưa kích hoạt</option>
                            <option value="locked" <?= $user['TrangThai'] === 'locked' ? 'selected' : '' ?>>Locked - Đã khóa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Vai trò hiện tại</label>
                        <div style="padding: 0.75rem; background: #F9FAFB; border-radius: 8px; border: 1px solid #E5E7EB;">
                            <?php
                            $roles = explode(',', $user['roles'] ?? '');
                            foreach ($roles as $role):
                                $roleColors = [
                                    'ADMIN' => 'error',
                                    'EMPLOYER' => 'warning',
                                    'APPLICANT' => 'primary'
                                ];
                                $badgeClass = $roleColors[$role] ?? 'primary';
                            ?>
                                <span class="badge badge-<?= $badgeClass ?>" style="margin-right: 0.5rem;">
                                    <?= e($role) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <small style="color: #6B7280; font-size: 0.875rem;">Vai trò không thể thay đổi từ đây</small>
                    </div>

                    <div class="form-group">
                        <label>Đặt lại mật khẩu</label>
                        <input type="password" name="new_password" 
                               placeholder="Để trống nếu không đổi mật khẩu">
                        <small style="color: #6B7280; font-size: 0.875rem;">Chỉ nhập nếu muốn đặt lại mật khẩu cho user</small>
                    </div>

                    <div class="form-group">
                        <label>Ghi chú (Admin)</label>
                        <textarea name="ghi_chu" rows="3" 
                                  placeholder="Lý do chỉnh sửa tài khoản này..."></textarea>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info & Actions -->
        <div>
            <div class="card" style="margin-bottom: 1rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">Thông tin</h3>
                </div>
                <div class="card-body">
                    <div style="font-size: 0.875rem; color: #6B7280; line-height: 1.8;">
                        <p><strong>Ngày tạo:</strong><br><?= formatDateTime($user['NgayTao']) ?></p>
                        <p><strong>Cập nhật:</strong><br><?= formatDateTime($user['NgayCapNhat']) ?></p>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 1rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">Thao tác nhanh</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <a href="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>" 
                           class="btn btn-secondary btn-block">
                            Xem chi tiết
                        </a>
                        
                        <?php if ($user['TrangThai'] !== 'locked'): ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/status">
                                <input type="hidden" name="status" value="locked">
                                <button type="submit" class="btn btn-block" 
                                        style="background: #F59E0B; color: white;"
                                        onclick="return confirm('Khóa tài khoản này?')">
                                    Khóa tài khoản
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/status">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="btn btn-block btn-secondary">
                                    Mở khóa
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card" style="background: #FEF3C7; border-color: #F59E0B;">
                <div class="card-body">
                    <p style="color: #92400E; margin: 0; font-size: 0.875rem; line-height: 1.6;">
                        <strong>⚠️ Lưu ý:</strong> Mọi thay đổi sẽ được ghi log. Nếu đặt lại mật khẩu, 
                        hãy thông báo cho người dùng.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
