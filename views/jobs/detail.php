<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="job-detail">
        <div class="job-header">
            <div class="company-logo">
                <?php if ($job['Logo']): ?>
                    <img src="<?= ASSETS_URL ?>/uploads/<?= e($job['Logo']) ?>" alt="Logo">
                <?php else: ?>
                    <div class="logo-placeholder"><?= substr($job['ten_cong_ty'], 0, 1) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="job-title-section">
                <h1><?= e($job['TieuDe']) ?></h1>
                <h2><?= e($job['ten_cong_ty']) ?></h2>
                
                <div class="job-meta">
                    <span class="location">📍 <?= e($job['DiaDiem']) ?></span>
                    <span class="salary">💰 <?= formatMoney($job['MucLuong']) ?><?php if ($job['MucLuongMax']): ?> - <?= formatMoney($job['MucLuongMax']) ?><?php endif; ?></span>
                    <span class="type">⏰ <?= e($job['LoaiCongViec']) ?></span>
                    <span class="views">👁 <?= $job['LuotXem'] ?> lượt xem</span>
                </div>
                
                <div class="job-actions">
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'APPLICANT'): ?>
                        <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>/apply" class="btn btn-primary">Ứng tuyển ngay</a>
                        <button class="btn btn-secondary save-job-btn" data-job-id="<?= e($job['ID_BaiDang']) ?>">
                            <?= $is_saved ? '❤️ Đã lưu' : '🤍 Lưu tin' ?>
                        </button>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="<?= BASE_URL ?>/login" class="btn btn-primary">Đăng nhập để ứng tuyển</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="job-content">
            <div class="job-main">
                <section class="job-section">
                    <h3>Mô tả công việc</h3>
                    <div class="content">
                        <?= nl2br(e($job['MoTa'])) ?>
                    </div>
                </section>
                
                <section class="job-section">
                    <h3>Yêu cầu công việc</h3>
                    <div class="content">
                        <?= nl2br(e($job['YeuCau'])) ?>
                    </div>
                </section>
                
                <section class="job-section">
                    <h3>Thông tin chung</h3>
                    <ul class="info-list">
                        <li><strong>Cấp bậc:</strong> <?= e($job['CapBac']) ?></li>
                        <li><strong>Kinh nghiệm:</strong> <?= e($job['KinhNghiem']) ?></li>
                        <li><strong>Số lượng:</strong> <?= e($job['SoLuong']) ?> người</li>
                        <li><strong>Hạn nộp:</strong> <?= formatDate($job['NgayHetHan']) ?></li>
                        <li><strong>Ngày đăng:</strong> <?= formatDate($job['NgayDangTin']) ?></li>
                    </ul>
                </section>
            </div>
            
            <div class="job-sidebar">
                <div class="company-info">
                    <h3>Thông tin công ty</h3>
                    <h4><?= e($job['ten_cong_ty']) ?></h4>
                    
                    <?php if ($job['QuyMo']): ?>
                        <p><strong>Quy mô:</strong> <?= e($job['QuyMo']) ?></p>
                    <?php endif; ?>
                    
                    <?php if ($job['LinhVuc']): ?>
                        <p><strong>Lĩnh vực:</strong> <?= e($job['LinhVuc']) ?></p>
                    <?php endif; ?>
                    
                    <?php if ($job['dia_chi_cong_ty']): ?>
                        <p><strong>Địa chỉ:</strong> <?= e($job['dia_chi_cong_ty']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Danh sách đánh giá -->
        <?php if (!empty($reviews)): ?>
        <div style="margin-top: 2rem; padding: 2rem; background: white; border-radius: 12px; border: 1px solid #E5E7EB;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700;">📝 Đánh giá từ ứng viên</h3>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.5rem; color: #F59E0B; font-weight: 700;"><?= number_format($avg_rating, 1) ?></span>
                    <span style="color: #F59E0B;">★</span>
                    <span style="color: #6B7280;">(<?= $total_reviews ?> đánh giá)</span>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?php foreach ($reviews as $review): ?>
                <div style="padding: 1.5rem; background: #F9FAFB; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #3B82F6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                <?= strtoupper(substr($review['HoLot'], 0, 1)) ?>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;"><?= e($review['HoLot']) ?> <?= e($review['ten_ungvien']) ?></div>
                                <div style="font-size: 0.875rem; color: #6B7280;"><?= timeAgo($review['NgayDanhGia']) ?></div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.25rem; color: #F59E0B;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span><?= $i <= $review['DiemDanhGia'] ? '★' : '☆' ?></span>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php if ($review['NhanXet']): ?>
                    <p style="color: #4B5563; line-height: 1.6;"><?= e($review['NhanXet']) ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Form đánh giá nhà tuyển dụng -->
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'APPLICANT' && !$has_reviewed): ?>
        <div style="margin-top: 2rem; padding: 2rem; background: white; border-radius: 12px; border: 1px solid #E5E7EB;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">⭐ Đánh giá nhà tuyển dụng</h3>
            <form action="<?= BASE_URL ?>/applicant/review/<?= e($job['ID_NhaTuyenDung']) ?>" method="POST">
                <div class="form-group">
                    <label>Đánh giá của bạn</label>
                    <div style="display: flex; gap: 0.5rem; font-size: 2rem; margin-bottom: 1rem;">
                        <span class="star" data-rating="1" style="cursor: pointer; color: #D1D5DB;">★</span>
                        <span class="star" data-rating="2" style="cursor: pointer; color: #D1D5DB;">★</span>
                        <span class="star" data-rating="3" style="cursor: pointer; color: #D1D5DB;">★</span>
                        <span class="star" data-rating="4" style="cursor: pointer; color: #D1D5DB;">★</span>
                        <span class="star" data-rating="5" style="cursor: pointer; color: #D1D5DB;">★</span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" required>
                </div>
                <div class="form-group">
                    <label>Nhận xét</label>
                    <textarea name="content" rows="4" placeholder="Chia sẻ trải nghiệm của bạn với nhà tuyển dụng này..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Rating stars
document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        document.getElementById('rating-input').value = rating;
        
        document.querySelectorAll('.star').forEach((s, index) => {
            if (index < rating) {
                s.style.color = '#F59E0B';
            } else {
                s.style.color = '#D1D5DB';
            }
        });
    });
    
    star.addEventListener('mouseenter', function() {
        const rating = this.dataset.rating;
        document.querySelectorAll('.star').forEach((s, index) => {
            if (index < rating) {
                s.style.color = '#F59E0B';
            } else {
                s.style.color = '#D1D5DB';
            }
        });
    });
});

document.querySelector('.save-job-btn')?.addEventListener('click', function() {
    const jobId = this.dataset.jobId;
    const isSaved = this.textContent.includes('Đã lưu');
    const url = '<?= BASE_URL ?>/api/jobs/' + jobId + (isSaved ? '/unsave' : '/save');
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            this.textContent = isSaved ? '🤍 Lưu tin' : '❤️ Đã lưu';
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Có lỗi xảy ra');
    });
});
</script>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
