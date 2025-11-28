<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Quản lý yêu cầu hỗ trợ</h1>
            <p style="color: #6B7280;">Xử lý và theo dõi các yêu cầu hỗ trợ từ người dùng</p>
        </div>
    </div>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #3B82F6; margin-bottom: 0.5rem;">
                    <?= $stats['total'] ?>
                </div>
                <div style="color: #6B7280; font-size: 0.875rem;">Tổng số</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #10B981; margin-bottom: 0.5rem;">
                    <?= $stats['new'] ?>
                </div>
                <div style="color: #6B7280; font-size: 0.875rem;">Mới</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #F59E0B; margin-bottom: 0.5rem;">
                    <?= $stats['processing'] ?>
                </div>
                <div style="color: #6B7280; font-size: 0.875rem;">Đang xử lý</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #6B7280; margin-bottom: 0.5rem;">
                    <?= $stats['resolved'] ?>
                </div>
                <div style="color: #6B7280; font-size: 0.875rem;">Đã giải quyết</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <form method="GET" style="display: flex; gap: 1rem; align-items: end;">
                <div class="form-group" style="margin: 0; flex: 1;">
                    <label>Trạng thái</label>
                    <select name="trang_thai">
                        <option value="">Tất cả</option>
                        <option value="Mới" <?= $filters['trang_thai'] === 'Mới' ? 'selected' : '' ?>>Mới</option>
                        <option value="Đang xử lý" <?= $filters['trang_thai'] === 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                        <option value="Đã giải quyết" <?= $filters['trang_thai'] === 'Đã giải quyết' ? 'selected' : '' ?>>Đã giải quyết</option>
                        <option value="Đóng" <?= $filters['trang_thai'] === 'Đóng' ? 'selected' : '' ?>>Đóng</option>
                    </select>
                </div>
                <div class="form-group" style="margin: 0; flex: 1;">
                    <label>Mức độ ưu tiên</label>
                    <select name="do_uu_tien">
                        <option value="">Tất cả</option>
                        <option value="Thấp" <?= $filters['do_uu_tien'] === 'Thấp' ? 'selected' : '' ?>>Thấp</option>
                        <option value="Trung bình" <?= $filters['do_uu_tien'] === 'Trung bình' ? 'selected' : '' ?>>Trung bình</option>
                        <option value="Cao" <?= $filters['do_uu_tien'] === 'Cao' ? 'selected' : '' ?>>Cao</option>
                        <option value="Khẩn cấp" <?= $filters['do_uu_tien'] === 'Khẩn cấp' ? 'selected' : '' ?>>Khẩn cấp</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>
    </div>

    <!-- Tickets List -->
    <?php if (empty($tickets)): ?>
        <div class="card">
            <div class="card-body" style="padding: 3rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                <h3 style="color: #6B7280;">Không có yêu cầu hỗ trợ nào</h3>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <table class="table" style="table-layout: fixed; width: 100%;">
                <thead style="background: #F9FAFB;">
                    <tr>
                        <th style="width: 8%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">ID</th>
                        <th style="width: 25%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Tiêu đề</th>
                        <th style="width: 8%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Người gửi</th>
                        <th style="width: 10%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Loại</th>
                        <th style="width: 11%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Mức độ</th>
                        <th style="width: 11%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Trạng thái</th>
                        <th style="width: 10%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Ngày tạo</th>
                        <th style="width: 17%; font-weight: 600; color: #374151; font-size: 0.875rem; padding: 1rem;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: background 0.2s;"
                            onmouseover="this.style.background='#F9FAFB'"
                            onmouseout="this.style.background='white'">
                            <td style="font-family: monospace; font-size: 0.75rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 0.875rem; color: #6B7280;" title="<?= e($ticket['ID_Ticket']) ?>"><?= e($ticket['ID_Ticket']) ?></td>
                            <td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 0.875rem;">
                                <a href="<?= BASE_URL ?>/support/tickets/<?= e($ticket['ID_Ticket']) ?>" style="font-weight: 600; color: #111827; text-decoration: none;" title="<?= e($ticket['TieuDe']) ?>">
                                    <?= e($ticket['TieuDe']) ?>
                                </a>
                            </td>
                            <td style="font-size: 0.875rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 0.875rem; color: #6B7280;" title="<?= e($ticket['ID_NguoiDung']) ?>"><?= e($ticket['ID_NguoiDung']) ?></td>
                            <td style="text-align: center; padding: 0.875rem;">
                                <span class="badge badge-<?= $ticket['LoaiNguoiDung'] === 'APPLICANT' ? 'info' : 'primary' ?>" style="font-size: 0.75rem; padding: 0.375rem 0.75rem;">
                                    <?= $ticket['LoaiNguoiDung'] === 'APPLICANT' ? 'Ứng viên' : 'NTD' ?>
                                </span>
                            </td>
                            <td style="text-align: center; padding: 0.875rem;">
                                <?php
                                $priorityColors = [
                                    'Thấp' => 'info',
                                    'Trung bình' => 'primary',
                                    'Cao' => 'warning',
                                    'Khẩn cấp' => 'error'
                                ];
                                $priorityText = trim($ticket['DoUuTien']);
                                ?>
                                <span class="badge badge-<?= $priorityColors[$priorityText] ?? 'primary' ?>" style="font-size: 0.75rem; padding: 0.375rem 0.75rem;">
                                    <?= e($priorityText) ?>
                                </span>
                            </td>
                            <td style="text-align: center; padding: 0.875rem;">
                                <?php
                                $statusColors = [
                                    'Mới' => 'primary',
                                    'Đang xử lý' => 'warning',
                                    'Đã giải quyết' => 'success',
                                    'Đóng' => 'error'
                                ];
                                $statusText = trim($ticket['TrangThai']);
                                ?>
                                <span class="badge badge-<?= $statusColors[$statusText] ?? 'primary' ?>" style="font-size: 0.75rem; padding: 0.375rem 0.75rem;">
                                    <?= e($statusText) ?>
                                </span>
                            </td>
                            <td style="font-size: 0.875rem; white-space: nowrap; text-align: center; padding: 0.875rem; color: #6B7280;"><?= formatDate($ticket['NgayTao']) ?></td>
                            <td style="text-align: center; padding: 0.875rem;">
                                <a href="<?= BASE_URL ?>/support/tickets/<?= e($ticket['ID_Ticket']) ?>" class="btn btn-sm btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; border-radius: 6px;">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
