<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Chỉnh sửa tin tuyển dụng</h1>
            <p style="color: #6B7280;">Cập nhật thông tin tin tuyển dụng</p>
        </div>
        <a href="<?= BASE_URL ?>/employer/jobs" class="btn btn-secondary">← Quay lại</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/employer/jobs/<?= e($job['ID_BaiDang']) ?>/update">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <div class="form-group">
                            <label>Tiêu đề công việc *</label>
                            <input type="text" name="tieu_de" required value="<?= e($job['TieuDe']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Địa điểm *</label>
                            <input type="text" name="dia_diem" required value="<?= e($job['DiaDiem']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Loại công việc *</label>
                            <select name="loai_cong_viec" required>
                                <option value="Full-time" <?= $job['LoaiCongViec'] === 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                                <option value="Part-time" <?= $job['LoaiCongViec'] === 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                                <option value="Thực tập" <?= $job['LoaiCongViec'] === 'Thực tập' ? 'selected' : '' ?>>Thực tập</option>
                                <option value="Freelance" <?= $job['LoaiCongViec'] === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cấp bậc</label>
                            <input type="text" name="cap_bac" value="<?= e($job['CapBac']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Kinh nghiệm</label>
                            <input type="text" name="kinh_nghiem" value="<?= e($job['KinhNghiem']) ?>">
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label>Mức lương (VNĐ)</label>
                            <input type="number" name="muc_luong" value="<?= $job['MucLuong'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Mức lương tối đa (VNĐ)</label>
                            <input type="number" name="muc_luong_max" value="<?= $job['MucLuongMax'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Loại lương</label>
                            <select name="loai_luong">
                                <option value="Thỏa thuận" <?= $job['LoaiLuong'] === 'Thỏa thuận' ? 'selected' : '' ?>>Thỏa thuận</option>
                                <option value="Cố định" <?= $job['LoaiLuong'] === 'Cố định' ? 'selected' : '' ?>>Cố định</option>
                                <option value="Theo giờ" <?= $job['LoaiLuong'] === 'Theo giờ' ? 'selected' : '' ?>>Theo giờ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" name="so_luong" min="1" value="<?= $job['SoLuong'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Hạn nộp hồ sơ</label>
                            <input type="date" name="ngay_het_han" value="<?= date('Y-m-d', strtotime($job['NgayHetHan'])) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả công việc *</label>
                    <textarea name="mo_ta" rows="6" required><?= e($job['MoTa']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Yêu cầu công việc *</label>
                    <textarea name="yeu_cau" rows="6" required><?= e($job['YeuCau']) ?></textarea>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <a href="<?= BASE_URL ?>/employer/jobs" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
