<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">📝 Quản lý tin tuyển dụng</h1>
            <p style="color: #6B7280;">Quản lý tất cả tin tuyển dụng của bạn</p>
        </div>
        <a href="<?= BASE_URL ?>/employer/jobs/create" class="btn btn-primary">+ Đăng tin mới</a>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($jobs)): ?>
                <div style="text-align: center; padding: 3rem;">
                    <p style="color: #6B7280; font-size: 1.125rem; margin-bottom: 1.5rem;">Bạn chưa có tin tuyển dụng nào</p>
                    <a href="<?= BASE_URL ?>/employer/jobs/create" class="btn btn-primary btn-lg">Đăng tin đầu tiên</a>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #F9FAFB; border-bottom: 2px solid #E5E7EB;">
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Tiêu đề</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Địa điểm</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Ứng viên</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Lượt xem</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Trạng thái</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr style="border-bottom: 1px solid #E5E7EB;">
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
                                    <td style="padding: 1rem; color: #6B7280;">
                                        <?= e($job['DiaDiem']) ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <a href="<?= BASE_URL ?>/employer/applications?job_id=<?= e($job['ID_BaiDang']) ?>" 
                                           style="color: #3B82F6; font-weight: 600; text-decoration: none;">
                                            <?= $job['so_ung_tuyen'] ?>
                                        </a>
                                    </td>
                                    <td style="padding: 1rem; text-align: center; color: #6B7280;">
                                        <?= $job['LuotXem'] ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php
                                        $statusColors = [
                                            'active' => 'success',
                                            'inactive' => 'warning',
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
                                            <a href="<?= BASE_URL ?>/employer/jobs/<?= e($job['ID_BaiDang']) ?>/edit" 
                                               class="btn btn-sm btn-primary" title="Sửa">
                                                Sửa
                                            </a>
                                            <a href="<?= BASE_URL ?>/employer/applications?job_id=<?= e($job['ID_BaiDang']) ?>" 
                                               class="btn btn-sm btn-secondary" title="Xem ứng viên">
                                                Ứng viên
                                            </a>
                                            <form method="POST" action="<?= BASE_URL ?>/employer/jobs/<?= e($job['ID_BaiDang']) ?>/delete" 
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa tin này?')">
                                                <button type="submit" class="btn btn-sm" 
                                                        style="background: #EF4444; color: white;" title="Xóa">
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
