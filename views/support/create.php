<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div style="max-width: 700px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 0.5rem;">Tạo yêu cầu hỗ trợ</h1>
            <p style="color: #6B7280;">Mô tả vấn đề bạn gặp phải, chúng tôi sẽ hỗ trợ bạn sớm nhất</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>/support/create">
                    <div class="form-group">
                        <label>Tiêu đề *</label>
                        <input type="text" name="tieu_de" required placeholder="Mô tả ngắn gọn vấn đề...">
                    </div>

                    <div class="form-group">
                        <label>Mức độ ưu tiên</label>
                        <select name="do_uu_tien">
                            <option value="Thấp">Thấp - Không gấp</option>
                            <option value="Trung bình" selected>Trung bình - Bình thường</option>
                            <option value="Cao">Cao - Cần xử lý sớm</option>
                            <option value="Khẩn cấp">Khẩn cấp - Rất gấp</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mô tả chi tiết *</label>
                        <textarea name="noi_dung" rows="8" required 
                                  placeholder="Mô tả chi tiết vấn đề bạn gặp phải...&#10;&#10;Ví dụ:&#10;- Bạn đang làm gì khi gặp lỗi?&#10;- Lỗi xuất hiện như thế nào?&#10;- Bạn đã thử cách nào chưa?"></textarea>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="<?= BASE_URL ?>/support" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card" style="margin-top: 1.5rem; background: #DBEAFE; border-color: #3B82F6;">
            <div class="card-body">
                <h4 style="font-weight: 600; color: #1E40AF; margin-bottom: 0.75rem;">💡 Mẹo nhận hỗ trợ nhanh</h4>
                <ul style="color: #1E40AF; font-size: 0.875rem; line-height: 1.8; margin: 0; padding-left: 1.25rem;">
                    <li>Mô tả vấn đề rõ ràng và chi tiết</li>
                    <li>Đính kèm ảnh chụp màn hình nếu có</li>
                    <li>Cung cấp thông tin liên quan</li>
                    <li>Chọn mức độ ưu tiên phù hợp</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
