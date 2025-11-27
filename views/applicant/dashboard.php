<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">👋 Xin chào, <?= e($applicant['Ten']) ?>!</h1>
        <p style="color: #6B7280;">Chào mừng bạn quay trở lại</p>
    </div>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="background: white; border: 1px solid #E5E7EB;">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 700; color: #3B82F6; margin-bottom: 0.5rem;"><?= $stats['applications'] ?></div>
                <div style="color: #6B7280; font-size: 0.875rem;">Tổng số</div>
            </div>
        </div>
        <div class="card" style="background: white; border: 1px solid #E5E7EB;">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 700; color: #10B981; margin-bottom: 0.5rem;"><?= $stats['saved_jobs'] ?></div>
                <div style="color: #6B7280; font-size: 0.875rem;">Mới</div>
            </div>
        </div>
        <div class="card" style="background: white; border: 1px solid #E5E7EB;">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 700; color: #F59E0B; margin-bottom: 0.5rem;"><?= $stats['pending'] ?></div>
                <div style="color: #6B7280; font-size: 0.875rem;">Đang xử lý</div>
            </div>
        </div>
        <div class="card" style="background: white; border: 1px solid #E5E7EB;">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 700; color: #6B7280; margin-bottom: 0.5rem;"><?= $stats['interviews'] ?></div>
                <div style="color: #6B7280; font-size: 0.875rem;">Đã giải quyết</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            <!-- Recent Applications -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">📝 Đơn ứng tuyển gần đây</h2>
                    <a href="<?= BASE_URL ?>/applicant/applications" style="color: #3B82F6; font-size: 0.875rem;">Xem tất cả →</a>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if (empty($recent_applications)): ?>
                        <p style="padding: 2rem; text-align: center; color: #6B7280;">Bạn chưa ứng tuyển công việc nào</p>
                    <?php else: ?>
                        <?php foreach ($recent_applications as $app): ?>
                            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #E5E7EB;">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div style="flex: 1;">
                                        <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                                            <a href="<?= BASE_URL ?>/jobs/<?= e($app['ID_BaiDang']) ?>" style="color: #1F2937;">
                                                <?= e($app['TieuDe']) ?>
                                            </a>
                                        </h3>
                                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                            🏢 <?= e($app['ten_cong_ty']) ?> • 📍 <?= e($app['DiaDiem']) ?>
                                        </p>
                                        <p style="color: #9CA3AF; font-size: 0.875rem;">
                                            Nộp ngày: <?= formatDate($app['NgayUngTuyen']) ?>
                                        </p>
                                    </div>
                                    <span class="badge badge-<?= getStatusBadge($app['TrangThai']) ?>">
                                        <?= e($app['TrangThai']) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recommended Jobs -->
            <div class="card">
                <div class="card-header">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">💡 Công việc đề xuất</h2>
                </div>
                <div class="card-body">
                    <div style="display: grid; gap: 1rem;">
                        <?php if (empty($recommended_jobs)): ?>
                            <p style="text-align: center; color: #6B7280; padding: 2rem;">Chưa có công việc phù hợp</p>
                        <?php else: ?>
                            <?php foreach ($recommended_jobs as $job): ?>
                                <div style="padding: 1rem; border: 1px solid #E5E7EB; border-radius: 8px;">
                                    <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                                        <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" style="color: #1F2937;">
                                            <?= e($job['TieuDe']) ?>
                                        </a>
                                    </h3>
                                    <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                        🏢 <?= e($job['ten_cong_ty']) ?>
                                    </p>
                                    <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6B7280;">
                                        <span>📍 <?= e($job['DiaDiem']) ?></span>
                                        <span>💰 <?= formatSalary($job['MucLuong'], $job['MucLuong_Max'], $job['LoaiLuong']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Quick Actions -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">⚡ Thao tác nhanh</h3>
                </div>
                <div class="card-body">
                    <a href="<?= BASE_URL ?>/jobs" class="btn btn-primary btn-block" style="margin-bottom: 0.75rem;">
                        🔍 Tìm việc làm
                    </a>
                    <a href="<?= BASE_URL ?>/applicant/profile" class="btn btn-secondary btn-block" style="margin-bottom: 0.75rem;">
                        👤 Cập nhật hồ sơ
                    </a>
                    <a href="<?= BASE_URL ?>/applicant/saved-jobs" class="btn btn-secondary btn-block">
                        ❤️ Việc đã lưu
                    </a>
                </div>
            </div>

            <!-- Notifications -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">🔔 Thông báo</h3>
                    <a href="<?= BASE_URL ?>/applicant/notifications" style="color: #3B82F6; font-size: 0.875rem;">Xem tất cả</a>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if (empty($notifications)): ?>
                        <p style="padding: 1.5rem; text-align: center; color: #6B7280; font-size: 0.875rem;">Không có thông báo mới</p>
                    <?php else: ?>
                        <?php foreach ($notifications as $notif): ?>
                            <div style="padding: 1rem; border-bottom: 1px solid #E5E7EB; <?= $notif['DaDoc'] ? '' : 'background: #EFF6FF;' ?>">
                                <p style="font-weight: 600; font-size: 0.875rem; margin-bottom: 0.25rem;"><?= e($notif['TieuDe']) ?></p>
                                <p style="color: #6B7280; font-size: 0.75rem; margin-bottom: 0.25rem;"><?= e($notif['NoiDung']) ?></p>
                                <p style="color: #9CA3AF; font-size: 0.75rem;"><?= timeAgo($notif['NgayTao']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
