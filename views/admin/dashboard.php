<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Admin Dashboard</h1>
        <p style="color: #6B7280;">Chào mừng quay trở lại, Admin!</p>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Tổng người dùng</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1F2937;"><?= $stats['total_users'] ?></h3>
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
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Ứng viên</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1F2937;"><?= $stats['total_applicants'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #D1FAE5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        👤
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Nhà tuyển dụng</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1F2937;"><?= $stats['total_employers'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        🏢
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Bài đăng</p>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1F2937;"><?= $stats['total_jobs'] ?></h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: #E0E7FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        💼
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Latest Jobs -->
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1F2937;">Bài đăng mới nhất</h2>
            </div>
            <div class="card-body">
                <?php if (empty($latest_jobs)): ?>
                    <p style="color: #6B7280; text-align: center; padding: 2rem;">Chưa có bài đăng nào</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($latest_jobs as $job): ?>
                            <div style="padding: 1rem; border: 1px solid #E5E7EB; border-radius: 8px;">
                                <h4 style="font-weight: 600; color: #1F2937; margin-bottom: 0.5rem;">
                                    <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" style="color: inherit; text-decoration: none;">
                                        <?= e($job['TieuDe']) ?>
                                    </a>
                                </h4>
                                <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                    <?= e($job['ten_cong_ty']) ?>
                                </p>
                                <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #9CA3AF;">
                                    <span>📍 <?= e($job['DiaDiem']) ?></span>
                                    <span>👁 <?= $job['LuotXem'] ?> lượt xem</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div style="text-align: center; margin-top: 1rem;">
                        <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-outline">Xem tất cả →</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Latest Users -->
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1F2937;">Người dùng mới</h2>
            </div>
            <div class="card-body">
                <?php if (empty($latest_users)): ?>
                    <p style="color: #6B7280; text-align: center; padding: 2rem;">Chưa có người dùng nào</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($latest_users as $user): ?>
                            <div style="padding: 1rem; border: 1px solid #E5E7EB; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p style="font-weight: 600; color: #1F2937; margin-bottom: 0.25rem;">
                                        <?= e($user['Email']) ?>
                                    </p>
                                    <p style="font-size: 0.875rem; color: #6B7280;">
                                        <?= e($user['roles'] ?? 'N/A') ?>
                                    </p>
                                </div>
                                <span class="badge badge-<?= $user['TrangThai'] === 'active' ? 'success' : 'warning' ?>">
                                    <?= e($user['TrangThai']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div style="text-align: center; margin-top: 1rem;">
                        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline">Xem tất cả →</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1F2937;">Thao tác nhanh</h2>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="<?= BASE_URL ?>/admin/users" class="btn btn-primary">
                    Quản lý người dùng
                </a>
                <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-primary">
                    Quản lý bài đăng
                </a>
                <a href="<?= BASE_URL ?>/jobs" class="btn btn-secondary">
                    Xem trang công khai
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
