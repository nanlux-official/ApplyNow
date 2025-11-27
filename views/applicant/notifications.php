<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">🔔 Thông báo</h1>
            <p style="color: #6B7280;">Các thông báo và cập nhật từ hệ thống</p>
        </div>
        <a href="<?= BASE_URL ?>/applicant/dashboard" class="btn btn-secondary">← Dashboard</a>
    </div>

    <div class="card">
        <?php if (empty($notifications)): ?>
            <div class="card-body" style="padding: 3rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🔕</div>
                <h3 style="color: #6B7280; margin-bottom: 0.5rem;">Không có thông báo</h3>
                <p style="color: #9CA3AF;">Bạn chưa có thông báo nào</p>
            </div>
        <?php else: ?>
            <div class="card-body" style="padding: 0;">
                <?php foreach ($notifications as $notif): ?>
                    <div style="padding: 1.5rem; border-bottom: 1px solid #E5E7EB; <?= $notif['DaDoc'] ? '' : 'background: #EFF6FF;' ?>">
                        <div style="display: flex; gap: 1rem;">
                            <div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 50%; background: <?= getNotificationColor($notif['Loai']) ?>; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <?= getNotificationIcon($notif['Loai']) ?>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                    <h3 style="font-weight: 600; font-size: 1rem; margin: 0;">
                                        <?= e($notif['TieuDe']) ?>
                                    </h3>
                                    <?php if (!$notif['DaDoc']): ?>
                                        <span style="width: 8px; height: 8px; background: #3B82F6; border-radius: 50%; flex-shrink: 0; margin-top: 0.25rem;"></span>
                                    <?php endif; ?>
                                </div>
                                <p style="color: #374151; line-height: 1.6; margin-bottom: 0.5rem; white-space: pre-wrap;">
                                    <?= e($notif['NoiDung']) ?>
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <p style="color: #9CA3AF; font-size: 0.875rem; margin: 0;">
                                        <?= timeAgo($notif['NgayTao']) ?>
                                    </p>
                                    <?php if (!empty($notif['ID_DonUngTuyen'])): ?>
                                        <a href="<?= BASE_URL ?>/applicant/applications/<?= e($notif['ID_DonUngTuyen']) ?>" 
                                           class="btn btn-sm btn-primary">
                                            Xem chi tiết
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
