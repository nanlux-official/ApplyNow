<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Chi tiết yêu cầu hỗ trợ</h1>
            <p style="color: #6B7280;">Theo dõi tiến trình xử lý</p>
        </div>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ADMIN'): ?>
            <a href="<?= BASE_URL ?>/admin/support" class="btn btn-secondary">← Quay lại</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/support" class="btn btn-secondary">← Quay lại</a>
        <?php endif; ?>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Ticket Content -->
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h2 style="font-size: 1.25rem; font-weight: 700;"><?= e($ticket['TieuDe']) ?></h2>
                </div>
                <div class="card-body">
                    <p style="color: #374151; line-height: 1.8; white-space: pre-wrap;"><?= e($ticket['NoiDung']) ?></p>
                    <div style="border-top: 1px solid #E5E7EB; margin-top: 1.5rem; padding-top: 1rem;">
                        <p style="color: #9CA3AF; font-size: 0.875rem;">
                            Tạo lúc: <?= formatDateTime($ticket['NgayTao']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            <?php if (!empty($replies)): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 style="font-size: 1.125rem; font-weight: 700;">💬 Phản hồi</h3>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <?php foreach ($replies as $reply): ?>
                            <div style="padding: 1rem; border-bottom: 1px solid #E5E7EB; <?= $reply['LoaiNguoiGui'] === 'ADMIN' ? 'background: #F0FDF4;' : '' ?>">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span style="font-weight: 600; color: <?= $reply['LoaiNguoiGui'] === 'ADMIN' ? '#059669' : '#1F2937' ?>;">
                                        <?= $reply['LoaiNguoiGui'] === 'ADMIN' ? '👨‍💼 Admin' : '👤 Bạn' ?>
                                    </span>
                                    <span style="color: #9CA3AF; font-size: 0.875rem;">
                                        <?= timeAgo($reply['NgayTao']) ?>
                                    </span>
                                </div>
                                <p style="color: #374151; line-height: 1.6; white-space: pre-wrap;"><?= e($reply['NoiDung']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Reply Form -->
            <?php if ($ticket['TrangThai'] !== 'Đóng'): ?>
                <div class="card" style="margin-top: 1.5rem;">
                    <div class="card-header">
                        <h3 style="font-size: 1.125rem; font-weight: 700;">✍️ Thêm phản hồi</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/support/tickets/<?= e($ticket['ID_Ticket']) ?>/reply">
                            <div class="form-group">
                                <textarea name="noi_dung" rows="4" required placeholder="Nhập phản hồi của bạn..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">📊 Thông tin</h3>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 1rem;">
                        <strong style="font-size: 0.875rem;">Trạng thái:</strong>
                        <?php
                        $statusColors = [
                            'Mới' => 'primary',
                            'Đang xử lý' => 'warning',
                            'Đã giải quyết' => 'success',
                            'Đóng' => 'error'
                        ];
                        ?>
                        <p style="margin-top: 0.25rem;">
                            <span class="badge badge-<?= $statusColors[$ticket['TrangThai']] ?? 'primary' ?>">
                                <?= e($ticket['TrangThai']) ?>
                            </span>
                        </p>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <strong style="font-size: 0.875rem;">Mức độ:</strong>
                        <?php
                        $priorityColors = [
                            'Thấp' => 'info',
                            'Trung bình' => 'primary',
                            'Cao' => 'warning',
                            'Khẩn cấp' => 'error'
                        ];
                        ?>
                        <p style="margin-top: 0.25rem;">
                            <span class="badge badge-<?= $priorityColors[$ticket['DoUuTien']] ?? 'primary' ?>">
                                <?= e($ticket['DoUuTien']) ?>
                            </span>
                        </p>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <strong style="font-size: 0.875rem;">Mã ticket:</strong>
                        <p style="margin-top: 0.25rem; font-family: monospace; font-size: 0.875rem;">
                            <?= e($ticket['ID_Ticket']) ?>
                        </p>
                    </div>
                    
                    <?php if (!empty($ticket['GhiChu'])): ?>
                        <div style="border-top: 1px solid #E5E7EB; padding-top: 1rem; margin-top: 1rem;">
                            <strong style="font-size: 0.875rem;">Ghi chú từ Admin:</strong>
                            <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #374151; line-height: 1.6;">
                                <?= nl2br(e($ticket['GhiChu'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Admin: Update Status & Reply -->
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ADMIN'): ?>
                <div class="card" style="margin-top: 1.5rem;">
                    <div class="card-header">
                        <h3 style="font-size: 1.125rem; font-weight: 700;">⚙️ Quản lý ticket</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin/support/<?= e($ticket['ID_Ticket']) ?>/status">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status" required>
                                    <option value="Mới" <?= $ticket['TrangThai'] === 'Mới' ? 'selected' : '' ?>>Mới</option>
                                    <option value="Đang xử lý" <?= $ticket['TrangThai'] === 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                                    <option value="Đã giải quyết" <?= $ticket['TrangThai'] === 'Đã giải quyết' ? 'selected' : '' ?>>Đã giải quyết</option>
                                    <option value="Đóng" <?= $ticket['TrangThai'] === 'Đóng' ? 'selected' : '' ?>>Đóng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ghi chú nội bộ</label>
                                <textarea name="note" rows="2" placeholder="Ghi chú cho admin..."><?= e($ticket['GhiChu'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Cập nhật</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
