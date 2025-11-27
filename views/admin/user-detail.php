<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">👤 Chi tiết người dùng</h1>
            <p style="color: #6B7280;">Thông tin chi tiết tài khoản</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- User Info -->
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 1.25rem; font-weight: 700;">Thông tin tài khoản</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <td style="padding: 1rem; font-weight: 600; color: #374151; width: 200px;">ID Tài khoản</td>
                        <td style="padding: 1rem; color: #6B7280; font-family: monospace;"><?= e($user['ID_TaiKhoan']) ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <td style="padding: 1rem; font-weight: 600; color: #374151;">Email</td>
                        <td style="padding: 1rem; color: #374151;"><?= e($user['Email']) ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <td style="padding: 1rem; font-weight: 600; color: #374151;">Vai trò</td>
                        <td style="padding: 1rem;">
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
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <td style="padding: 1rem; font-weight: 600; color: #374151;">Trạng thái</td>
                        <td style="padding: 1rem;">
                            <?php
                            $statusColors = [
                                'active' => 'success',
                                'inactive' => 'warning',
                                'locked' => 'error'
                            ];
                            $badgeClass = $statusColors[$user['TrangThai']] ?? 'primary';
                            ?>
                            <span class="badge badge-<?= $badgeClass ?>">
                                <?= e($user['TrangThai']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <td style="padding: 1rem; font-weight: 600; color: #374151;">Ngày tạo</td>
                        <td style="padding: 1rem; color: #6B7280;"><?= formatDateTime($user['NgayTao']) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; font-weight: 600; color: #374151;">Cập nhật lần cuối</td>
                        <td style="padding: 1rem; color: #6B7280;"><?= formatDateTime($user['NgayCapNhat']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div>
            <div class="card" style="margin-bottom: 1rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">Thao tác</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <!-- Change Role -->
                        <?php if (!in_array('ADMIN', $roles)): ?>
                            <div style="background: #F9FAFB; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/change-role">
                                    <label style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.75rem; display: block;">
                                        🔄 Thay đổi vai trò
                                    </label>
                                    <div class="form-group" style="margin-bottom: 0.75rem;">
                                        <select name="new_role" required style="width: 100%; padding: 0.5rem; border: 1px solid #D1D5DB; border-radius: 0.375rem; font-size: 0.875rem;">
                                            <option value="">-- Chọn vai trò --</option>
                                            <option value="APPLICANT" <?= in_array('APPLICANT', $roles) ? 'selected' : '' ?>>Ứng viên</option>
                                            <option value="EMPLOYER" <?= in_array('EMPLOYER', $roles) ? 'selected' : '' ?>>Nhà tuyển dụng</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-primary" style="width: 100%; padding: 0.625rem; font-size: 0.875rem;"
                                            onclick="return confirm('Bạn có chắc muốn thay đổi vai trò?')">
                                        Cập nhật vai trò
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($user['TrangThai'] !== 'locked'): ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/status">
                                <input type="hidden" name="status" value="locked">
                                <button type="submit" class="btn btn-block" 
                                        style="background: #F59E0B; color: white;"
                                        onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                                    🔒 Khóa tài khoản
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/status">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="btn btn-block btn-secondary">
                                    🔓 Mở khóa tài khoản
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <?php if (!in_array('ADMIN', $roles)): ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/delete">
                                <button type="submit" class="btn btn-block" 
                                        style="background: #EF4444; color: white;"
                                        onclick="return confirm('Bạn có chắc muốn xóa tài khoản này? Hành động này không thể hoàn tác!')">
                                    🗑️ Xóa tài khoản
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">⚠️ Cảnh báo</h3>
                </div>
                <div class="card-body">
                    <p style="color: #6B7280; font-size: 0.875rem; line-height: 1.6;">
                        Các thao tác trên tài khoản sẽ được ghi log và không thể hoàn tác. 
                        Hãy cân nhắc kỹ trước khi thực hiện.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
