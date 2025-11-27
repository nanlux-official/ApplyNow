<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">👥 Quản lý người dùng</h1>
            <p style="color: #6B7280;">Quản lý tất cả tài khoản trong hệ thống</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-secondary">← Quay lại Dashboard</a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filter -->
            <form method="GET" style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                <input type="text" name="keyword" placeholder="Tìm email..." 
                       value="<?= e(input('keyword', '')) ?>"
                       style="flex: 1; padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                
                <select name="role" style="padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                    <option value="">Tất cả vai trò</option>
                    <option value="APPLICANT" <?= input('role') === 'APPLICANT' ? 'selected' : '' ?>>Ứng viên</option>
                    <option value="EMPLOYER" <?= input('role') === 'EMPLOYER' ? 'selected' : '' ?>>Nhà tuyển dụng</option>
                    <option value="ADMIN" <?= input('role') === 'ADMIN' ? 'selected' : '' ?>>Admin</option>
                </select>
                
                <select name="status" style="padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" <?= input('status') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= input('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="locked" <?= input('status') === 'locked' ? 'selected' : '' ?>>Locked</option>
                </select>
                
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>

            <!-- Users Table -->
            <?php if (empty($users)): ?>
                <p style="text-align: center; padding: 3rem; color: #6B7280;">Không có người dùng nào</p>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #F9FAFB; border-bottom: 2px solid #E5E7EB;">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">ID</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Email</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Vai trò</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Trạng thái</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Ngày tạo</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr style="border-bottom: 1px solid #E5E7EB;">
                                    <td style="padding: 1rem; color: #6B7280; font-family: monospace; font-size: 0.875rem;">
                                        <?= e(substr($user['ID_TaiKhoan'], 0, 8)) ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 500; color: #374151;">
                                            <?= e($user['Email']) ?>
                                        </div>
                                    </td>
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
                                            <span class="badge badge-<?= $badgeClass ?>" style="margin-right: 0.25rem;">
                                                <?= e($role) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
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
                                    <td style="padding: 1rem; color: #6B7280; font-size: 0.875rem;">
                                        <?= formatDate($user['NgayTao']) ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <!-- View Details -->
                                            <a href="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>" 
                                               class="btn btn-sm btn-secondary" title="Xem chi tiết">
                                                👁️
                                            </a>
                                            
                                            <!-- Edit -->
                                            <a href="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/edit" 
                                               class="btn btn-sm btn-primary" title="Sửa">
                                                ✏️
                                            </a>
                                            
                                            <!-- Toggle Status -->
                                            <?php if ($user['TrangThai'] !== 'locked'): ?>
                                                <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/status" style="display: inline;">
                                                    <input type="hidden" name="status" value="locked">
                                                    <button type="submit" class="btn btn-sm" 
                                                            style="background: #F59E0B; color: white;"
                                                            title="Khóa tài khoản"
                                                            onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                                                        🔒
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/status" style="display: inline;">
                                                    <input type="hidden" name="status" value="active">
                                                    <button type="submit" class="btn btn-sm btn-secondary" 
                                                            title="Mở khóa">
                                                        🔓
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <!-- Delete -->
                                            <?php if (!in_array('ADMIN', $roles)): ?>
                                                <form method="POST" action="<?= BASE_URL ?>/admin/users/<?= e($user['ID_TaiKhoan']) ?>/delete" 
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này? Hành động này không thể hoàn tác!')">
                                                    <button type="submit" class="btn btn-sm" 
                                                            style="background: #EF4444; color: white;"
                                                            title="Xóa">
                                                        🗑️
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pagination['total_pages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['has_prev']): ?>
                            <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="btn btn-secondary">← Trước</a>
                        <?php endif; ?>
                        
                        <span class="page-info">
                            Trang <?= $pagination['current_page'] ?> / <?= $pagination['total_pages'] ?>
                        </span>
                        
                        <?php if ($pagination['has_next']): ?>
                            <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="btn btn-secondary">Sau →</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}
</style>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
