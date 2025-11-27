<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">📄 Chi tiết đơn ứng tuyển</h1>
            <p style="color: #6B7280;">Thông tin chi tiết về đơn ứng tuyển của bạn</p>
        </div>
        <a href="<?= BASE_URL ?>/applicant/applications" class="btn btn-secondary">← Quay lại</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Job Info -->
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h2 style="font-size: 1.25rem; font-weight: 700;">💼 Thông tin công việc</h2>
                </div>
                <div class="card-body">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1F2937; margin-bottom: 1rem;">
                        <?= e($application['TieuDe']) ?>
                    </h3>
                    
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <?php if (!empty($application['Logo'])): ?>
                            <img src="<?= ASSETS_URL ?>/uploads/<?= e($application['Logo']) ?>" 
                                 style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                        <?php endif; ?>
                        <div style="flex: 1;">
                            <h4 style="font-weight: 600; margin-bottom: 0.25rem;"><?= e($application['ten_cong_ty']) ?></h4>
                            <p style="color: #6B7280; font-size: 0.875rem;">📍 <?= e($application['DiaDiem']) ?></p>
                        </div>
                        <button onclick="showReviewModal()" class="btn btn-sm btn-secondary">⭐ Đánh giá</button>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; padding: 1rem; background: #F9FAFB; border-radius: 8px;">
                        <div>
                            <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.25rem;">💰 Mức lương</p>
                            <p style="font-weight: 600;"><?= formatSalary($application['MucLuong'], $application['MucLuong_Max'] ?? null, $application['LoaiLuong'] ?? 'Thỏa thuận') ?></p>
                        </div>
                        <div>
                            <p style="color: #6B7280; font-size: 0.875rem; margin-bottom: 0.25rem;">📅 Ngày ứng tuyển</p>
                            <p style="font-weight: 600;"><?= formatDate($application['NgayUngTuyen']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($application['ThuXinViec'])): ?>
                <div class="card">
                    <div class="card-header">
                        <h2 style="font-size: 1.25rem; font-weight: 700;">✉️ Thư xin việc của bạn</h2>
                    </div>
                    <div class="card-body">
                        <p style="color: #374151; line-height: 1.8; white-space: pre-wrap;"><?= e($application['ThuXinViec']) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Status Sidebar -->
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="font-size: 1.125rem; font-weight: 700;">📊 Trạng thái đơn</h3>
                </div>
                <div class="card-body">
                    <div style="text-align: center; padding: 1.5rem 0;">
                        <span class="badge badge-<?= getStatusBadge($application['TrangThai']) ?>" 
                              style="font-size: 1.125rem; padding: 0.75rem 1.5rem;">
                            <?= e($application['TrangThai']) ?>
                        </span>
                    </div>
                    
                    <?php if (!empty($application['FileCV'])): ?>
                        <div style="border-top: 1px solid #E5E7EB; padding-top: 1rem; margin-top: 1rem;">
                            <p style="font-weight: 600; margin-bottom: 0.5rem;">📎 CV đã nộp</p>
                            <a href="<?= ASSETS_URL ?>/uploads/cv/<?= e($application['FileCV']) ?>" 
                               target="_blank" class="btn btn-secondary btn-block">
                                Xem CV
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($notifications)): ?>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3 style="font-size: 1.125rem; font-weight: 700;">📢 Thông báo từ NTD</h3>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <?php foreach ($notifications as $notif): ?>
                            <div style="padding: 0.75rem 1rem; border-bottom: 1px solid #E5E7EB; <?= $notif === end($notifications) ? 'border-bottom: none;' : '' ?>">
                                <p style="font-weight: 600; font-size: 0.8125rem; margin-bottom: 0.5rem; color: #1F2937; line-height: 1.4;">
                                    <?= e($notif['TieuDe']) ?>
                                </p>
                                <div style="color: #4B5563; font-size: 0.8125rem; line-height: 1.5; margin-bottom: 0.5rem; word-wrap: break-word;">
                                    <?php
                                    // Tách nội dung thành các phần
                                    $parts = explode("\n\n📝 Thông báo từ nhà tuyển dụng:\n", $notif['NoiDung']);
                                    echo '<p style="margin: 0 0 0.5rem 0;">' . nl2br(e($parts[0])) . '</p>';
                                    
                                    // Hiển thị phần thông báo tùy chỉnh nếu có
                                    if (isset($parts[1])) {
                                        echo '<div style="background: #FEF3C7; padding: 0.5rem; border-radius: 4px; margin-top: 0.5rem;">';
                                        echo '<p style="font-weight: 600; font-size: 0.75rem; color: #92400E; margin: 0 0 0.25rem 0;">📝 Thông báo từ nhà tuyển dụng:</p>';
                                        echo '<p style="color: #92400E; font-size: 0.8125rem; margin: 0;">' . nl2br(e(trim($parts[1]))) . '</p>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <p style="color: #9CA3AF; font-size: 0.75rem; margin: 0;">
                                    <?= timeAgo($notif['NgayTao']) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="card" style="background: #FEF3C7; border-color: #F59E0B;">
                <div class="card-body">
                    <h4 style="font-weight: 600; color: #92400E; margin-bottom: 0.75rem;">💡 Lưu ý</h4>
                    <ul style="color: #92400E; font-size: 0.875rem; line-height: 1.8; margin: 0; padding-left: 1.25rem;">
                        <li>Theo dõi email thường xuyên</li>
                        <li>Chuẩn bị kỹ cho phỏng vấn</li>
                        <li>Cập nhật hồ sơ định kỳ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đánh giá -->
<div id="reviewModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #E5E7EB;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">⭐ Đánh giá nhà tuyển dụng</h3>
        </div>
        <form method="POST" action="<?= BASE_URL ?>/applicant/review/<?= e($application['ID_NhaTuyenDung']) ?>" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Đánh giá (1-5 sao) *</label>
                <div style="display: flex; gap: 0.5rem; font-size: 2rem;">
                    <span class="star" data-rating="1" onclick="setRating(1)" style="cursor: pointer; color: #D1D5DB;">★</span>
                    <span class="star" data-rating="2" onclick="setRating(2)" style="cursor: pointer; color: #D1D5DB;">★</span>
                    <span class="star" data-rating="3" onclick="setRating(3)" style="cursor: pointer; color: #D1D5DB;">★</span>
                    <span class="star" data-rating="4" onclick="setRating(4)" style="cursor: pointer; color: #D1D5DB;">★</span>
                    <span class="star" data-rating="5" onclick="setRating(5)" style="cursor: pointer; color: #D1D5DB;">★</span>
                </div>
                <input type="hidden" name="rating" id="ratingInput" required>
            </div>
            
            <div class="form-group">
                <label>Nhận xét *</label>
                <textarea name="content" rows="5" required placeholder="Chia sẻ trải nghiệm của bạn với nhà tuyển dụng này..."></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="hideReviewModal()" class="btn btn-secondary">Hủy</button>
                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
            </div>
        </form>
    </div>
</div>

<script>
let selectedRating = 0;

function showReviewModal() {
    document.getElementById('reviewModal').style.display = 'flex';
}

function hideReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
}

function setRating(rating) {
    selectedRating = rating;
    document.getElementById('ratingInput').value = rating;
    
    // Update star colors
    document.querySelectorAll('.star').forEach((star, index) => {
        if (index < rating) {
            star.style.color = '#F59E0B';
        } else {
            star.style.color = '#D1D5DB';
        }
    });
}

// Close modal when clicking outside
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideReviewModal();
    }
});
</script>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
