<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Chỉnh sửa bài đăng</h1>
            <p style="color: #6B7280;">Cập nhật thông tin bài đăng tuyển dụng</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/admin/jobs/<?= e($job['ID_BaiDang']) ?>/update">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Left Column -->
                    <div>
                        <div class="form-group">
                            <label>Tiêu đề công việc *</label>
                            <input type="text" name="tieu_de" required 
                                   value="<?= e($job['TieuDe']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Công ty</label>
                            <input type="text" value="<?= e($job['ten_cong_ty']) ?>" disabled
                                   style="background: #F3F4F6; cursor: not-allowed;">
                            <small style="color: #6B7280; font-size: 0.875rem;">Không thể thay đổi công ty</small>
                        </div>

                        <div class="form-group">
                            <label>Địa điểm *</label>
                            <input type="text" name="dia_diem" required 
                                   value="<?= e($job['DiaDiem']) ?>">
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
                            <input type="text" name="cap_bac" 
                                   value="<?= e($job['CapBac']) ?>"
                                   placeholder="VD: Nhân viên, Trưởng nhóm...">
                        </div>

                        <div class="form-group">
                            <label>Kinh nghiệm</label>
                            <input type="text" name="kinh_nghiem" 
                                   value="<?= e($job['KinhNghiem']) ?>"
                                   placeholder="VD: 1-2 năm, 3-5 năm...">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="form-group">
                            <label>Mức lương (VNĐ)</label>
                            <input type="number" name="muc_luong" 
                                   value="<?= $job['MucLuong'] ?>"
                                   placeholder="Mức lương tối thiểu">
                        </div>

                        <div class="form-group">
                            <label>Mức lương tối đa (VNĐ)</label>
                            <input type="number" name="muc_luong_max" 
                                   value="<?= $job['MucLuongMax'] ?>"
                                   placeholder="Mức lương tối đa">
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
                            <label>Số lượng tuyển</label>
                            <input type="number" name="so_luong" min="1" 
                                   value="<?= $job['SoLuong'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Ngày hết hạn</label>
                            <input type="date" name="ngay_het_han" 
                                   value="<?= date('Y-m-d', strtotime($job['NgayHetHan'])) ?>">
                        </div>

                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="trang_thai">
                                <option value="active" <?= $job['TrangThai'] === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $job['TrangThai'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="hidden" <?= $job['TrangThai'] === 'hidden' ? 'selected' : '' ?>>Hidden</option>
                                <option value="expired" <?= $job['TrangThai'] === 'expired' ? 'selected' : '' ?>>Expired</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Full Width Fields -->
                <div class="form-group">
                    <label>Mô tả công việc *</label>
                    <textarea name="mo_ta" rows="6" required><?= e($job['MoTa']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Yêu cầu công việc *</label>
                    <textarea name="yeu_cau" rows="6" required><?= e($job['YeuCau']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Lý do chỉnh sửa (Admin)</label>
                    <textarea name="ly_do" rows="2" placeholder="Ghi chú lý do chỉnh sửa bài đăng này..."></textarea>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Box -->
    <div class="card" style="margin-top: 1rem; background: #FEF3C7; border-color: #F59E0B;">
        <div class="card-body">
            <p style="color: #92400E; margin: 0;">
                <strong>⚠️ Lưu ý:</strong> Mọi thay đổi sẽ được ghi log và thông báo đến nhà tuyển dụng.
            </p>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
