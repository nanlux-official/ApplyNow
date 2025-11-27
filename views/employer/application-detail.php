<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">📄 Chi tiết đơn ứng tuyển</h1>
            <p style="color: #6B7280;">Thông tin chi tiết hồ sơ ứng viên</p>
        </div>
        <a href="<?= BASE_URL ?>/employer/applications" class="btn btn-secondary">← Quay lại</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem; max-width: 100%;">
        <!-- Applicant Info -->
        <div style="min-width: 0;">
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">👤 Thông tin ứng viên</h2>
                </div>
                <div class="card-body">
                    <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                        <?php if (!empty($application['AnhDaiDien'])): ?>
                            <img src="<?= ASSETS_URL ?>/uploads/<?= e($application['AnhDaiDien']) ?>" 
                                 style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; flex-shrink: 0;">
                        <?php else: ?>
                            <div style="width: 80px; height: 80px; border-radius: 12px; background: #3B82F6; color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; flex-shrink: 0;">
                                <?= strtoupper(substr($application['ten_ungvien'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <div style="min-width: 0; flex: 1;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: #1F2937; margin-bottom: 0.5rem; word-wrap: break-word;">
                                <?= e($application['HoLot']) ?> <?= e($application['ten_ungvien']) ?>
                            </h3>
                            <p style="color: #6B7280; margin-bottom: 0.25rem; font-size: 0.875rem; word-wrap: break-word;">📧 <?= e($application['Email']) ?></p>
                            <p style="color: #6B7280; margin-bottom: 0.25rem; font-size: 0.875rem;">📱 <?= e($application['SDT']) ?></p>
                            <?php if (!empty($application['DiaChi'])): ?>
                                <p style="color: #6B7280; font-size: 0.875rem; word-wrap: break-word;">📍 <?= e($application['DiaChi']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($application['KyNang'])): ?>
                        <div style="border-top: 1px solid #E5E7EB; padding-top: 1rem; margin-top: 1rem;">
                            <h4 style="font-weight: 600; margin-bottom: 0.75rem; font-size: 1rem;">💼 Kỹ năng</h4>
                            <p style="color: #374151; line-height: 1.6; font-size: 0.875rem; word-wrap: break-word;"><?= nl2br(e($application['KyNang'])) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($application['KinhNghiem'])): ?>
                        <div style="border-top: 1px solid #E5E7EB; padding-top: 1rem; margin-top: 1rem;">
                            <h4 style="font-weight: 600; margin-bottom: 0.75rem; font-size: 1rem;">📚 Kinh nghiệm</h4>
                            <p style="color: #374151; line-height: 1.6; font-size: 0.875rem; word-wrap: break-word;"><?= nl2br(e($application['KinhNghiem'])) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($application['HocVan'])): ?>
                        <div style="border-top: 1px solid #E5E7EB; padding-top: 1rem; margin-top: 1rem;">
                            <h4 style="font-weight: 600; margin-bottom: 0.75rem; font-size: 1rem;">🎓 Học vấn</h4>
                            <p style="color: #374151; line-height: 1.6; font-size: 0.875rem; word-wrap: break-word;"><?= nl2br(e($application['HocVan'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($application['ThuXinViec'])): ?>
                <div class="card">
                    <div class="card-header">
                        <h2 style="font-size: 1.25rem; font-weight: 700;">✉️ Thư xin việc</h2>
                    </div>
                    <div class="card-body">
                        <p style="color: #374151; line-height: 1.8; white-space: pre-wrap; word-wrap: break-word; font-size: 0.875rem;"><?= e($application['ThuXinViec']) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions Sidebar -->
        <div style="min-width: 0;">
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">📋 Thông tin đơn</h3>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 1rem;">
                        <strong style="font-size: 0.875rem;">Vị trí:</strong>
                        <p style="margin-top: 0.25rem; font-size: 0.875rem; word-wrap: break-word;"><?= e($application['TieuDe']) ?></p>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <strong style="font-size: 0.875rem;">Ngày nộp:</strong>
                        <p style="margin-top: 0.25rem; font-size: 0.875rem;"><?= formatDateTime($application['NgayUngTuyen']) ?></p>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <strong style="font-size: 0.875rem;">Trạng thái:</strong>
                        <?php
                        $statusColors = [
                            'Mới nộp' => 'primary',
                            'Đã xem' => 'info',
                            'Mời phỏng vấn' => 'warning',
                            'Từ chối' => 'error',
                            'Trúng tuyển' => 'success'
                        ];
                        $badgeClass = $statusColors[$application['TrangThai']] ?? 'primary';
                        ?>
                        <p style="margin-top: 0.25rem;">
                            <span class="badge badge-<?= $badgeClass ?>">
                                <?= e($application['TrangThai']) ?>
                            </span>
                        </p>
                    </div>
                    
                    <div style="border-top: 1px solid #E5E7EB; padding-top: 1rem; margin-top: 1rem;">
                        <strong style="font-size: 0.875rem; display: block; margin-bottom: 0.5rem;">📎 CV ứng viên</strong>
                        <?php if (!empty($application['FileCV'])): ?>
                            <a href="<?= ASSETS_URL ?>/uploads/cv/<?= e($application['FileCV']) ?>" 
                               target="_blank" class="btn btn-secondary btn-block" style="font-size: 0.875rem;">
                                📥 Tải xuống CV
                            </a>
                            <p style="font-size: 0.75rem; color: #6B7280; margin-top: 0.5rem; text-align: center;">
                                <?= e($application['FileCV']) ?>
                            </p>
                        <?php else: ?>
                            <p style="font-size: 0.875rem; color: #9CA3AF; text-align: center; padding: 1rem; background: #F9FAFB; border-radius: 4px;">
                                Ứng viên chưa nộp CV
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">⚡ Cập nhật trạng thái</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/employer/applications/<?= e($application['ID_DonUngTuyen']) ?>/status">
                        <div class="form-group">
                            <label style="font-size: 0.875rem;">Trạng thái mới</label>
                            <select name="status" required style="font-size: 0.875rem;">
                                <option value="Đã xem">Đã xem</option>
                                <option value="Mời phỏng vấn">Mời phỏng vấn</option>
                                <option value="Từ chối">Từ chối</option>
                                <option value="Trúng tuyển">Trúng tuyển</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 0.875rem;">Thông báo cho ứng viên</label>
                            <textarea name="message" rows="3" style="font-size: 0.875rem;"
                                      placeholder="Nhập thông báo tùy chỉnh (tùy chọn)..."></textarea>
                            <small style="color: #6B7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">
                                Hệ thống sẽ tự động gửi thông báo.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="font-size: 0.875rem;">
                            📤 Cập nhật & Gửi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
