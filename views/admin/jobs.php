<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Quản lý bài đăng</h1>
            <p style="color: #6B7280;">Quản lý tất cả bài đăng tuyển dụng trong hệ thống</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-secondary">← Quay lại Dashboard</a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filter -->
            <form method="GET" style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                <input type="text" name="keyword" placeholder="Tìm kiếm..." 
                       value="<?= e(input('keyword', '')) ?>"
                       style="flex: 1; padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                
                <select name="status" style="padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" <?= input('status') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= input('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="hidden" <?= input('status') === 'hidden' ? 'selected' : '' ?>>Hidden</option>
                    <option value="expired" <?= input('status') === 'expired' ? 'selected' : '' ?>>Expired</option>
                </select>
                
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>

            <!-- Jobs Table -->
            <?php if (empty($jobs)): ?>
                <p style="text-align: center; padding: 3rem; color: #6B7280;">Không có bài đăng nào</p>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #F9FAFB; border-bottom: 2px solid #E5E7EB;">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">ID</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Tiêu đề</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Công ty</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Địa điểm</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Ứng viên</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Lượt xem</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Trạng thái</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr style="border-bottom: 1px solid #E5E7EB;">
                                    <td style="padding: 1rem; color: #6B7280; font-family: monospace;">
                                        <?= e(substr($job['ID_BaiDang'], 0, 8)) ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" 
                                           target="_blank"
                                           style="color: #3B82F6; text-decoration: none; font-weight: 500;">
                                            <?= e($job['TieuDe']) ?>
                                        </a>
                                        <div style="font-size: 0.875rem; color: #6B7280; margin-top: 0.25rem;">
                                            <?= formatDate($job['NgayDangTin']) ?>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: #374151;">
                                        <?= e($job['ten_cong_ty']) ?>
                                    </td>
                                    <td style="padding: 1rem; color: #6B7280;">
                                        <?= e($job['DiaDiem']) ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center; font-weight: 600; color: #3B82F6;">
                                        <?= $job['so_ung_tuyen'] ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center; color: #6B7280;">
                                        <?= $job['LuotXem'] ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php
                                        $statusColors = [
                                            'active' => 'success',
                                            'inactive' => 'warning',
                                            'hidden' => 'error',
                                            'expired' => 'error'
                                        ];
                                        $badgeClass = $statusColors[$job['TrangThai']] ?? 'primary';
                                        ?>
                                        <span class="badge badge-<?= $badgeClass ?>">
                                            <?= e($job['TrangThai']) ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <!-- Edit -->
                                            <a href="<?= BASE_URL ?>/admin/jobs/<?= e($job['ID_BaiDang']) ?>/edit" 
                                               class="btn btn-sm btn-primary" 
                                               title="Sửa">
                                                Sửa
                                            </a>
                                            
                                            <!-- Toggle Status -->
                                            <form method="POST" action="<?= BASE_URL ?>/admin/jobs/<?= e($job['ID_BaiDang']) ?>/status" style="display: inline;">
                                                <input type="hidden" name="status" value="<?= $job['TrangThai'] === 'active' ? 'hidden' : 'active' ?>">
                                                <button type="submit" class="btn btn-sm btn-secondary" 
                                                        title="<?= $job['TrangThai'] === 'active' ? 'Ẩn' : 'Hiện' ?>">
                                                    <?= $job['TrangThai'] === 'active' ? 'Ẩn' : 'Hiện' ?>
                                                </button>
                                            </form>
                                            
                                            <!-- Delete -->
                                            <form method="POST" action="<?= BASE_URL ?>/admin/jobs/<?= e($job['ID_BaiDang']) ?>/delete" 
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa bài đăng này?')">
                                                <button type="submit" class="btn btn-sm" 
                                                        style="background: #EF4444; color: white;"
                                                        title="Xóa">
                                                    Xóa
                                                </button>
                                            </form>
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
