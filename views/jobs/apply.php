<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">📤 Ứng tuyển công việc</h1>
            <p style="color: #6B7280;">Hoàn tất thông tin để gửi đơn ứng tuyển</p>
        </div>

        <!-- Job Info -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-body">
                <div style="display: flex; gap: 1rem; align-items: start;">
                    <?php if (!empty($job['Logo'])): ?>
                        <img src="<?= ASSETS_URL ?>/uploads/<?= e($job['Logo']) ?>" 
                             style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                    <?php endif; ?>
                    <div style="flex: 1;">
                        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">
                            <?= e($job['TieuDe']) ?>
                        </h2>
                        <p style="color: #6B7280; margin-bottom: 0.25rem;">🏢 <?= e($job['ten_cong_ty']) ?></p>
                        <p style="color: #6B7280; font-size: 0.875rem;">
                            📍 <?= e($job['DiaDiem']) ?> • 
                            💰 <?= formatSalary($job['MucLuong'], $job['MucLuong_Max'] ?? null, $job['LoaiLuong'] ?? 'Thỏa thuận') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 700;">📝 Thông tin ứng tuyển</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>/apply" enctype="multipart/form-data">
                    <!-- Applicant Info (Read-only) -->
                    <div style="background: #F9FAFB; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <h4 style="font-weight: 600; margin-bottom: 1rem;">👤 Thông tin của bạn</h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; font-size: 0.875rem;">
                            <div>
                                <p style="color: #6B7280; margin-bottom: 0.25rem;">Họ tên</p>
                                <p style="font-weight: 600;"><?= e($applicant['HoLot']) ?> <?= e($applicant['Ten']) ?></p>
                            </div>
                            <div>
                                <p style="color: #6B7280; margin-bottom: 0.25rem;">Email</p>
                                <p style="font-weight: 600;"><?= e($applicant['Email']) ?></p>
                            </div>
                            <div>
                                <p style="color: #6B7280; margin-bottom: 0.25rem;">Số điện thoại</p>
                                <p style="font-weight: 600;"><?= e($applicant['SDT'] ?? 'Chưa cập nhật') ?></p>
                            </div>
                            <div>
                                <p style="color: #6B7280; margin-bottom: 0.25rem;">Địa chỉ</p>
                                <p style="font-weight: 600;"><?= e($applicant['DiaChi'] ?? 'Chưa cập nhật') ?></p>
                            </div>
                        </div>
                        <p style="margin-top: 1rem; font-size: 0.875rem; color: #6B7280;">
                            <a href="<?= BASE_URL ?>/applicant/profile" style="color: #3B82F6;">Cập nhật thông tin →</a>
                        </p>
                    </div>

                    <!-- CV Upload -->
                    <div class="form-group">
                        <label>📎 Upload CV *</label>
                        <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required>
                        <small style="color: #6B7280; font-size: 0.875rem; display: block; margin-top: 0.5rem;">
                            Chấp nhận file PDF, DOC, DOCX (tối đa 10MB)
                        </small>
                    </div>

                    <!-- Cover Letter -->
                    <div class="form-group">
                        <label>✉️ Thư xin việc</label>
                        <textarea name="thu_xin_viec" rows="8" 
                                  placeholder="Giới thiệu bản thân và lý do bạn phù hợp với vị trí này..."></textarea>
                        <small style="color: #6B7280; font-size: 0.875rem; display: block; margin-top: 0.5rem;">
                            Một thư xin việc tốt sẽ tăng cơ hội được chọn
                        </small>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                        <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" class="btn btn-secondary">
                            Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Gửi đơn ứng tuyển
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips -->
        <div class="card" style="margin-top: 1.5rem; background: #DBEAFE; border-color: #3B82F6;">
            <div class="card-body">
                <h4 style="font-weight: 600; color: #1E40AF; margin-bottom: 0.75rem;">💡 Mẹo ứng tuyển thành công</h4>
                <ul style="color: #1E40AF; font-size: 0.875rem; line-height: 1.8; margin: 0; padding-left: 1.25rem;">
                    <li>Đọc kỹ mô tả công việc và yêu cầu</li>
                    <li>CV nên rõ ràng, ngắn gọn và liên quan đến vị trí</li>
                    <li>Thư xin việc thể hiện sự nhiệt tình và phù hợp</li>
                    <li>Kiểm tra kỹ thông tin trước khi gửi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
