<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">👥 Quản lý ứng viên</h1>
            <p style="color: #6B7280;">Xem và quản lý hồ sơ ứng viên</p>
        </div>
        <a href="<?= BASE_URL ?>/employer/dashboard" class="btn btn-secondary">← Dashboard</a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                <select name="job_id" style="flex: 1; padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                    <option value="">Tất cả tin tuyển dụng</option>
                    <?php foreach ($jobs as $job): ?>
                        <option value="<?= e($job['ID_BaiDang']) ?>" <?= $filters['job_id'] === $job['ID_BaiDang'] ? 'selected' : '' ?>>
                            <?= e($job['TieuDe']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="trang_thai" style="padding: 0.75rem; border: 2px solid #E5E7EB; border-radius: 8px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Mới nộp" <?= $filters['trang_thai'] === 'Mới nộp' ? 'selected' : '' ?>>Mới nộp</option>
                    <option value="Đã xem" <?= $filters['trang_thai'] === 'Đã xem' ? 'selected' : '' ?>>Đã xem</option>
                    <option value="Mời phỏng vấn" <?= $filters['trang_thai'] === 'Mời phỏng vấn' ? 'selected' : '' ?>>Mời phỏng vấn</option>
                    <option value="Từ chối" <?= $filters['trang_thai'] === 'Từ chối' ? 'selected' : '' ?>>Từ chối</option>
                    <option value="Trúng tuyển" <?= $filters['trang_thai'] === 'Trúng tuyển' ? 'selected' : '' ?>>Trúng tuyển</option>
                </select>
                
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>

            <!-- Applications List -->
            <?php if (empty($applications)): ?>
                <p style="text-align: center; padding: 3rem; color: #6B7280;">
                    Chưa có ứng viên nào
                    <?php if (isset($filters['trang_thai']) && !empty($filters['trang_thai'])): ?>
                        <br><small>với trạng thái "<?= e($filters['trang_thai']) ?>"</small>
                    <?php endif; ?>
                </p>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #F9FAFB; border-bottom: 2px solid #E5E7EB;">
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Ứng viên</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Vị trí ứng tuyển</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Liên hệ</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Ngày nộp</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Trạng thái</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $app): ?>
                                <tr style="border-bottom: 1px solid #E5E7EB;">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <?php if ($app['AnhDaiDien']): ?>
                                                <img src="<?= ASSETS_URL ?>/uploads/<?= e($app['AnhDaiDien']) ?>" 
                                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 40px; height: 40px; border-radius: 50%; background: #3B82F6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                                    <?= substr($app['ten_ungvien'], 0, 1) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p style="font-weight: 600; color: #1F2937;">
                                                    <?= e($app['HoLot']) ?> <?= e($app['ten_ungvien']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: #374151;">
                                        <?= e($app['TieuDe']) ?>
                                    </td>
                                    <td style="padding: 1rem; color: #6B7280; font-size: 0.875rem;">
                                        📧 <?= e($app['Email']) ?><br>
                                        📱 <?= e($app['SDT']) ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center; color: #6B7280; font-size: 0.875rem;">
                                        <?= formatDate($app['NgayUngTuyen']) ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php
                                        $statusColors = [
                                            'Mới nộp' => 'primary',
                                            'Đã xem' => 'info',
                                            'Mời phỏng vấn' => 'warning',
                                            'Từ chối' => 'error',
                                            'Trúng tuyển' => 'success'
                                        ];
                                        $badgeClass = $statusColors[$app['TrangThai']] ?? 'primary';
                                        ?>
                                        <span class="badge badge-<?= $badgeClass ?>">
                                            <?= e($app['TrangThai']) ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <a href="<?= BASE_URL ?>/employer/applications/<?= e($app['ID_DonUngTuyen']) ?>" 
                                               class="btn btn-sm btn-primary">
                                                Xem chi tiết
                                            </a>
                                            <form method="POST" action="<?= BASE_URL ?>/employer/applications/<?= e($app['ID_DonUngTuyen']) ?>/delete" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa đơn ứng tuyển này?');">
                                                <button type="submit" class="btn btn-sm btn-error">Xóa</button>
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

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
