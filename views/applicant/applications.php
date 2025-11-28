<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Lịch sử ứng tuyển</h1>
            <p style="color: #6B7280;">Theo dõi trạng thái các đơn ứng tuyển của bạn</p>
        </div>
        <a href="<?= BASE_URL ?>/applicant/dashboard" class="btn btn-secondary">← Dashboard</a>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <form method="GET" style="display: flex; gap: 1rem; align-items: end;">
                <div class="form-group" style="flex: 1; margin: 0;">
                    <label>Trạng thái</label>
                    <select name="trang_thai">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Mới nộp" <?= $filters['trang_thai'] === 'Mới nộp' ? 'selected' : '' ?>>Mới nộp</option>
                        <option value="Đã xem" <?= $filters['trang_thai'] === 'Đã xem' ? 'selected' : '' ?>>Đã xem</option>
                        <option value="Mời phỏng vấn" <?= $filters['trang_thai'] === 'Mời phỏng vấn' ? 'selected' : '' ?>>Mời phỏng vấn</option>
                        <option value="Từ chối" <?= $filters['trang_thai'] === 'Từ chối' ? 'selected' : '' ?>>Từ chối</option>
                        <option value="Trúng tuyển" <?= $filters['trang_thai'] === 'Trúng tuyển' ? 'selected' : '' ?>>Trúng tuyển</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>
    </div>

    <!-- Applications List -->
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <?php if (empty($applications)): ?>
                <div style="padding: 3rem; text-align: center;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                    <h3 style="color: #6B7280; margin-bottom: 0.5rem;">Chưa có đơn ứng tuyển</h3>
                    <p style="color: #9CA3AF; margin-bottom: 1.5rem;">Hãy bắt đầu tìm kiếm và ứng tuyển công việc phù hợp</p>
                    <a href="<?= BASE_URL ?>/jobs" class="btn btn-primary">Tìm việc làm</a>
                </div>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #F9FAFB; border-bottom: 2px solid #E5E7EB;">
                        <tr>
                            <th style="padding: 1rem; text-align: left; font-weight: 600;">Vị trí ứng tuyển</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600;">Công ty</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600;">Ngày nộp</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600;">Trạng thái</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr style="border-bottom: 1px solid #E5E7EB;">
                                <td style="padding: 1rem;">
                                    <a href="<?= BASE_URL ?>/jobs/<?= e($app['ID_BaiDang']) ?>" style="color: #1F2937; font-weight: 600;">
                                        <?= e($app['TieuDe']) ?>
                                    </a>
                                    <p style="color: #6B7280; font-size: 0.875rem; margin-top: 0.25rem;">
                                        📍 <?= e($app['DiaDiem']) ?>
                                    </p>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <?php if (!empty($app['Logo'])): ?>
                                            <img src="<?= ASSETS_URL ?>/uploads/<?= e($app['Logo']) ?>" 
                                                 style="width: 32px; height: 32px; border-radius: 4px; object-fit: cover;">
                                        <?php endif; ?>
                                        <span><?= e($app['ten_cong_ty']) ?></span>
                                    </div>
                                </td>
                                <td style="padding: 1rem; color: #6B7280; font-size: 0.875rem;">
                                    <?= formatDate($app['NgayUngTuyen']) ?>
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="badge badge-<?= getStatusBadge($app['TrangThai']) ?>">
                                        <?= e($app['TrangThai']) ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?= BASE_URL ?>/applicant/applications/<?= e($app['ID_DonUngTuyen']) ?>" 
                                           class="btn btn-sm btn-primary">
                                            Xem chi tiết
                                        </a>
                                        <?php if (in_array($app['TrangThai'], ['Mới nộp', 'Từ chối'])): ?>
                                            <form method="POST" action="<?= BASE_URL ?>/applicant/applications/<?= e($app['ID_DonUngTuyen']) ?>/delete" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa đơn ứng tuyển này?');">
                                                <button type="submit" class="btn btn-sm btn-error">Xóa</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
