<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">❤️ Công việc đã lưu</h1>
            <p style="color: #6B7280;">Danh sách các công việc bạn quan tâm</p>
        </div>
        <a href="<?= BASE_URL ?>/applicant/dashboard" class="btn btn-secondary">← Dashboard</a>
    </div>

    <?php if (empty($saved_jobs)): ?>
        <div class="card">
            <div class="card-body" style="padding: 3rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">💔</div>
                <h3 style="color: #6B7280; margin-bottom: 0.5rem;">Chưa có công việc đã lưu</h3>
                <p style="color: #9CA3AF; margin-bottom: 1.5rem;">Hãy lưu các công việc bạn quan tâm để xem lại sau</p>
                <a href="<?= BASE_URL ?>/jobs" class="btn btn-primary">Tìm việc làm</a>
            </div>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 1.5rem;">
            <?php foreach ($saved_jobs as $job): ?>
                <div class="card">
                    <div class="card-body">
                        <div style="display: flex; gap: 1.5rem;">
                            <?php if (!empty($job['Logo'])): ?>
                                <img src="<?= ASSETS_URL ?>/uploads/<?= e($job['Logo']) ?>" 
                                     style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                            <?php else: ?>
                                <div style="width: 80px; height: 80px; border-radius: 8px; background: #E5E7EB; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span style="font-size: 2rem;">🏢</span>
                                </div>
                            <?php endif; ?>
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                                    <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">
                                        <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" style="color: #1F2937;">
                                            <?= e($job['TieuDe']) ?>
                                        </a>
                                    </h3>
                                    <button onclick="unsaveJob('<?= e($job['ID_BaiDang']) ?>')" 
                                            class="btn btn-sm btn-error" style="flex-shrink: 0;">
                                        ❌ Bỏ lưu
                                    </button>
                                </div>
                                
                                <p style="color: #6B7280; margin-bottom: 0.75rem; font-weight: 500;">
                                    🏢 <?= e($job['ten_cong_ty']) ?>
                                </p>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: #6B7280; margin-bottom: 1rem;">
                                    <span>📍 <?= e($job['DiaDiem']) ?></span>
                                    <span>💰 <?= formatSalary($job['MucLuong'], $job['MucLuong_Max'] ?? null, $job['LoaiLuong'] ?? 'Thỏa thuận') ?></span>
                                    <span>⏰ <?= e($job['LoaiCongViec'] ?? 'Full-time') ?></span>
                                </div>
                                
                                <div style="display: flex; gap: 0.75rem;">
                                    <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" class="btn btn-primary">
                                        Xem chi tiết
                                    </a>
                                    <?php if (!$job['da_ung_tuyen']): ?>
                                        <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>/apply" class="btn btn-success">
                                            📤 Ứng tuyển ngay
                                        </a>
                                    <?php else: ?>
                                        <span class="badge badge-success" style="padding: 0.5rem 1rem;">Đã ứng tuyển</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function unsaveJob(jobId) {
    if (!confirm('Bạn có chắc muốn bỏ lưu công việc này?')) return;
    
    fetch('<?= BASE_URL ?>/applicant/saved-jobs/' + jobId + '/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra');
    });
}
</script>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
