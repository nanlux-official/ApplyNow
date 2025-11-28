<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Yêu cầu trở thành Nhà tuyển dụng</h1>
            <p style="color: #6B7280;">Điền đầy đủ thông tin công ty để chúng tôi xét duyệt</p>
        </div>

        <div class="card" style="background: #DBEAFE; border-color: #3B82F6; margin-bottom: 2rem;">
            <div class="card-body">
                <h4 style="font-weight: 600; color: #1E40AF; margin-bottom: 0.75rem;">📋 Yêu cầu</h4>
                <ul style="color: #1E40AF; font-size: 0.875rem; line-height: 1.8; margin: 0; padding-left: 1.25rem;">
                    <li>Cung cấp thông tin công ty chính xác</li>
                    <li>Mã số thuế hợp lệ (10-13 số)</li>
                    <li>Địa chỉ công ty rõ ràng</li>
                    <li>Thời gian xét duyệt: 1-3 ngày làm việc</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 1.25rem; font-weight: 700;">Thông tin công ty</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>/support/upgrade-employer">
                    <div class="form-group">
                        <label>Tên công ty *</label>
                        <input type="text" name="ten_cong_ty" required placeholder="VD: Công ty TNHH ABC">
                    </div>

                    <div class="form-group">
                        <label>Mã số thuế *</label>
                        <input type="text" name="ma_so_thue" required pattern="[0-9]{10,13}" 
                               placeholder="VD: 0123456789" 
                               title="Mã số thuế phải là 10-13 chữ số">
                        <small style="color: #6B7280; font-size: 0.875rem;">Nhập 10-13 chữ số</small>
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ công ty *</label>
                        <input type="text" name="dia_chi" required placeholder="VD: 123 Đường ABC, Quận 1, TP.HCM">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Số điện thoại *</label>
                            <input type="tel" name="so_dien_thoai" required pattern="[0-9]{10,11}" 
                                   placeholder="VD: 0901234567">
                        </div>

                        <div class="form-group">
                            <label>Email công ty *</label>
                            <input type="email" name="email_cong_ty" required placeholder="VD: contact@company.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Website (nếu có)</label>
                        <input type="url" name="website" placeholder="VD: https://company.com">
                    </div>

                    <div class="form-group">
                        <label>Quy mô công ty *</label>
                        <select name="quy_mo" required>
                            <option value="">-- Chọn quy mô --</option>
                            <option value="1-10">1-10 nhân viên</option>
                            <option value="11-50">11-50 nhân viên</option>
                            <option value="51-200">51-200 nhân viên</option>
                            <option value="201-500">201-500 nhân viên</option>
                            <option value="500+">Trên 500 nhân viên</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lĩnh vực hoạt động *</label>
                        <input type="text" name="linh_vuc" required placeholder="VD: Công nghệ thông tin, Thương mại điện tử">
                    </div>

                    <div class="form-group">
                        <label>Mô tả về công ty *</label>
                        <textarea name="mo_ta" rows="5" required 
                                  placeholder="Giới thiệu về công ty, lĩnh vực kinh doanh, sản phẩm/dịch vụ chính..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Lý do muốn trở thành nhà tuyển dụng *</label>
                        <textarea name="ly_do" rows="4" required 
                                  placeholder="Chia sẻ lý do bạn muốn đăng tin tuyển dụng trên nền tảng của chúng tôi..."></textarea>
                    </div>

                    <div style="background: #F3F4F6; padding: 1rem; border-radius: 0.5rem; margin-top: 1.5rem;">
                        <label style="display: flex; align-items: start; gap: 0.75rem; cursor: pointer; font-size: 0.875rem;">
                            <input type="checkbox" name="dong_y" required style="margin-top: 0.25rem; width: 18px; height: 18px; cursor: pointer;">
                            <span style="line-height: 1.6;">
                                Tôi xác nhận thông tin trên là chính xác và đồng ý với 
                                <a href="#" style="color: #3B82F6; text-decoration: underline;">điều khoản sử dụng</a> 
                                của nền tảng
                            </span>
                        </label>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #E5E7EB;">
                        <a href="<?= BASE_URL ?>/support" class="btn btn-secondary" style="padding: 0.75rem 2rem;">Hủy bỏ</a>
                        <button type="submit" class="btn btn-success" style="padding: 0.75rem 2rem;">Gửi yêu cầu</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card" style="margin-top: 1.5rem; background: #FEF3C7; border-color: #F59E0B;">
            <div class="card-body">
                <h4 style="font-weight: 600; color: #92400E; margin-bottom: 0.75rem;">⚠️ Lưu ý</h4>
                <ul style="color: #92400E; font-size: 0.875rem; line-height: 1.8; margin: 0; padding-left: 1.25rem;">
                    <li>Yêu cầu sẽ được gửi đến bộ phận quản trị để xét duyệt</li>
                    <li>Chúng tôi sẽ xác minh thông tin công ty qua mã số thuế</li>
                    <li>Bạn sẽ nhận được thông báo qua email khi được duyệt</li>
                    <li>Sau khi được duyệt, tài khoản sẽ được nâng cấp lên Nhà tuyển dụng</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
