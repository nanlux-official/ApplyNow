<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">➕ Đăng tin tuyển dụng</h1>
            <p style="color: #6B7280;">Tạo tin tuyển dụng mới để tìm ứng viên phù hợp</p>
        </div>
        <a href="<?= BASE_URL ?>/employer/dashboard" class="btn btn-secondary">← Quay lại</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/employer/jobs/create">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Left Column -->
                    <div>
                        <div class="form-group">
                            <label>Tiêu đề công việc *</label>
                            <input type="text" name="tieu_de" required 
                                   value="<?= e(getFlash('old')['tieu_de'] ?? '') ?>"
                                   placeholder="VD: PHP Developer, Marketing Manager...">
                            <?php if (hasFlash('errors') && isset(getFlash('errors')['tieu_de'])): ?>
                                <span class="error"><?= e(getFlash('errors')['tieu_de'][0]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Địa điểm làm việc *</label>
                            <input type="text" name="dia_diem" required 
                                   value="<?= e(getFlash('old')['dia_diem'] ?? '') ?>"
                                   placeholder="VD: Hà Nội, TP. Hồ Chí Minh...">
                        </div>

                        <div class="form-group">
                            <label>Loại công việc *</label>
                            <select name="loai_cong_viec" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Thực tập">Thực tập</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cấp bậc</label>
                            <input type="text" name="cap_bac" 
                                   value="<?= e(getFlash('old')['cap_bac'] ?? '') ?>"
                                   placeholder="VD: Nhân viên, Trưởng nhóm, Quản lý...">
                        </div>

                        <div class="form-group">
                            <label>Kinh nghiệm yêu cầu</label>
                            <input type="text" name="kinh_nghiem" 
                                   value="<?= e(getFlash('old')['kinh_nghiem'] ?? '') ?>"
                                   placeholder="VD: 1-2 năm, 3-5 năm, Chưa có kinh nghiệm...">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="form-group">
                            <label>Mức lương tối thiểu (VNĐ)</label>
                            <input type="number" name="muc_luong" 
                                   value="<?= e(getFlash('old')['muc_luong'] ?? '') ?>"
                                   placeholder="VD: 10000000">
                        </div>

                        <div class="form-group">
                            <label>Mức lương tối đa (VNĐ)</label>
                            <input type="number" name="muc_luong_max" 
                                   value="<?= e(getFlash('old')['muc_luong_max'] ?? '') ?>"
                                   placeholder="VD: 20000000">
                        </div>

                        <div class="form-group">
                            <label>Loại lương</label>
                            <select name="loai_luong">
                                <option value="Thỏa thuận">Thỏa thuận</option>
                                <option value="Cố định">Cố định</option>
                                <option value="Theo giờ">Theo giờ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Số lượng cần tuyển</label>
                            <input type="number" name="so_luong" min="1" value="1">
                        </div>

                        <div class="form-group">
                            <label>Hạn nộp hồ sơ</label>
                            <input type="date" name="ngay_het_han" 
                                   value="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                        </div>
                    </div>
                </div>

                <!-- Full Width Fields -->
                <div class="form-group">
                    <label>Mô tả công việc *</label>
                    <textarea name="mo_ta" rows="6" required 
                              placeholder="Mô tả chi tiết về công việc, trách nhiệm, quyền lợi..."><?= e(getFlash('old')['mo_ta'] ?? '') ?></textarea>
                    <?php if (hasFlash('errors') && isset(getFlash('errors')['mo_ta'])): ?>
                        <span class="error"><?= e(getFlash('errors')['mo_ta'][0]) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Yêu cầu công việc *</label>
                    <textarea name="yeu_cau" rows="6" required 
                              placeholder="Yêu cầu về kỹ năng, kinh nghiệm, bằng cấp..."><?= e(getFlash('old')['yeu_cau'] ?? '') ?></textarea>
                    <?php if (hasFlash('errors') && isset(getFlash('errors')['yeu_cau'])): ?>
                        <span class="error"><?= e(getFlash('errors')['yeu_cau'][0]) ?></span>
                    <?php endif; ?>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <a href="<?= BASE_URL ?>/employer/dashboard" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary btn-lg">Đăng tin tuyển dụng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
