<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Dashboard Nhà tuyển dụng</h1>
        <p style="color: #6B7280;">Chào mừng trở lại, <?= e($employer['Ten']) ?>!</p>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Tổng tin đăng</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1F2937;"><?= $stats['total_jobs'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #DBEAFE; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        💼
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Tin đang active</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #10B981;"><?= $stats['active_jobs'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #D1FAE5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        ✅
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Tổng ứng viên</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #3B82F6;"><?= $stats['total_applications'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #DBEAFE; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        👥
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Ứng viên mới</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #F59E0B;"><?= $stats['new_applications'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        🆕
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Latest Jobs -->
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">Tin tuyển dụng gần đây</h2>
                    <a href="<?= BASE_URL ?>/employer/jobs/create" class="btn btn-primary btn-sm">+ Đăng tin mới</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($latest_jobs)): ?>
                    <p style="text-align: center; padding: 2rem; color: #6B7280;">Chưa có tin tuyển dụng nào</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($latest_jobs as $job): ?>
                            <div style="padding: 1rem; border: 1px solid #E5E7EB; border-radius: 8px;">
                                <h4 style="font-weight: 600; margin-bottom: 0.5rem;">
                                    <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" target="_blank" style="color: #1F2937; text-decoration: none;">
                                        <?= e($job['TieuDe']) ?>
                                    </a>
                                </h4>
                                <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #6B7280;">
                                    <span>📍 <?= e($job['DiaDiem']) ?></span>
                                    <span>👥 <?= $job['so_ung_tuyen'] ?> ứng viên</span>
                                    <span>👁 <?= $job['LuotXem'] ?> lượt xem</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- New Applications -->
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">Ứng viên mới</h2>
                    <a href="<?= BASE_URL ?>/employer/applications" class="btn btn-secondary btn-sm">Xem tất cả</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($new_applications)): ?>
                    <p style="text-align: center; padding: 2rem; color: #6B7280;">Chưa có ứng viên mới</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($new_applications as $app): ?>
                            <div style="padding: 1rem; border: 1px solid #E5E7EB; border-radius: 8px;">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <p style="font-weight: 600; color: #1F2937; margin-bottom: 0.25rem;">
                                            <?= e($app['HoLot']) ?> <?= e($app['ten_ungvien']) ?>
                                        </p>
                                        <p style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.5rem;">
                                            <?= e($app['TieuDe']) ?>
                                        </p>
                                        <p style="font-size: 0.875rem; color: #9CA3AF;">
                                            <?= timeAgo($app['NgayUngTuyen']) ?>
                                        </p>
                                    </div>
                                    <a href="<?= BASE_URL ?>/employer/applications/<?= e($app['ID_DonUngTuyen']) ?>" class="btn btn-sm btn-primary">
                                        Xem
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h2 style="font-size: 1.25rem; font-weight: 700;">Thao tác nhanh</h2>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="<?= BASE_URL ?>/employer/jobs/create" class="btn btn-primary">
                    Đăng tin tuyển dụng
                </a>
                <a href="<?= BASE_URL ?>/employer/jobs" class="btn btn-secondary">
                    Quản lý tin đăng
                </a>
                <a href="<?= BASE_URL ?>/employer/applications" class="btn btn-secondary">
                    Quản lý ứng viên
                </a>
                <a href="<?= BASE_URL ?>/employer/profile" class="btn btn-secondary">
                    Thông tin công ty
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
