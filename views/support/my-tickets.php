<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">🎫 Yêu cầu hỗ trợ</h1>
            <p style="color: #6B7280;">Quản lý các yêu cầu hỗ trợ của bạn</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'APPLICANT'): ?>
                <a href="<?= BASE_URL ?>/support/upgrade-employer" class="btn btn-success">🏢 Trở thành NTD</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/support/create" class="btn btn-primary">+ Tạo yêu cầu mới</a>
        </div>
    </div>

    <?php if (empty($tickets)): ?>
        <div class="card">
            <div class="card-body" style="padding: 3rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                <h3 style="color: #6B7280; margin-bottom: 0.5rem;">Chưa có yêu cầu hỗ trợ</h3>
                <p style="color: #9CA3AF; margin-bottom: 1.5rem;">Tạo yêu cầu hỗ trợ khi bạn cần giúp đỡ</p>
                <a href="<?= BASE_URL ?>/support/create" class="btn btn-primary">Tạo yêu cầu</a>
            </div>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 1rem;">
            <?php foreach ($tickets as $ticket): ?>
                <div class="card">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">
                                    <a href="<?= BASE_URL ?>/support/tickets/<?= e($ticket['ID_Ticket']) ?>" style="color: #1F2937;">
                                        <?= e($ticket['TieuDe']) ?>
                                    </a>
                                </h3>
                                <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                    <?= truncate($ticket['NoiDung'], 150) ?>
                                </p>
                            </div>
                            <div style="display: flex; gap: 0.5rem; flex-shrink: 0; margin-left: 1rem;">
                                <?php
                                $statusColors = [
                                    'Mới' => 'primary',
                                    'Đang xử lý' => 'warning',
                                    'Đã giải quyết' => 'success',
                                    'Đóng' => 'error'
                                ];
                                $priorityColors = [
                                    'Thấp' => 'info',
                                    'Trung bình' => 'primary',
                                    'Cao' => 'warning',
                                    'Khẩn cấp' => 'error'
                                ];
                                ?>
                                <span class="badge badge-<?= $statusColors[$ticket['TrangThai']] ?? 'primary' ?>">
                                    <?= e($ticket['TrangThai']) ?>
                                </span>
                                <span class="badge badge-<?= $priorityColors[$ticket['DoUuTien']] ?? 'primary' ?>">
                                    <?= e($ticket['DoUuTien']) ?>
                                </span>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem; color: #9CA3AF;">
                            <span>Tạo: <?= formatDateTime($ticket['NgayTao']) ?></span>
                            <a href="<?= BASE_URL ?>/support/tickets/<?= e($ticket['ID_Ticket']) ?>" class="btn btn-sm btn-primary">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
