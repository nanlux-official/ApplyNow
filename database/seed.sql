-- =============================================
-- DỮ LIỆU MẪU CHO JOB PORTAL
-- =============================================

USE job_portal;

-- =============================================
-- 1. VAI TRÒ
-- =============================================
INSERT INTO VAITRO (ID_VaiTro, Ten, MoTa) VALUES
('VT001', 'APPLICANT', 'Ứng viên tìm việc'),
('VT002', 'EMPLOYER', 'Nhà tuyển dụng'),
('VT003', 'ADMIN', 'Quản trị viên hệ thống');

-- =============================================
-- 2. TÀI KHOẢN (Mật khẩu: 123456 - đã hash bằng password_hash)
-- =============================================
INSERT INTO TAIKHOAN (ID_TaiKhoan, Email, Pass, TrangThai) VALUES
-- Admin
('TK001', 'admin@jobportal.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
-- Ứng viên
('TK002', 'nguyenvana@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
('TK003', 'tranthib@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
('TK004', 'levanc@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
-- Nhà tuyển dụng
('TK005', 'hr@fpt.com.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
('TK006', 'tuyendung@viettel.com.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
('TK007', 'hr@vingroup.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active');

-- =============================================
-- 3. PHÂN QUYỀN
-- =============================================
INSERT INTO TAIKHOANVAITRO (ID, ID_TaiKhoan, ID_VaiTro) VALUES
('TKVT001', 'TK001', 'VT003'), -- Admin
('TKVT002', 'TK002', 'VT001'), -- Ứng viên
('TKVT003', 'TK003', 'VT001'),
('TKVT004', 'TK004', 'VT001'),
('TKVT005', 'TK005', 'VT002'), -- Nhà tuyển dụng
('TKVT006', 'TK006', 'VT002'),
('TKVT007', 'TK007', 'VT002');

-- =============================================
-- 4. ỨNG VIÊN
-- =============================================
INSERT INTO UNGVIEN (ID_UngVien, ID_TaiKhoan, HoLot, Ten, SDT, Email, NgaySinh, GioiTinh, DiaChi) VALUES
('UV001', 'TK002', 'Nguyễn Văn', 'A', '0901234567', 'nguyenvana@gmail.com', '1995-05-15', 'Nam', 'Hà Nội'),
('UV002', 'TK003', 'Trần Thị', 'B', '0912345678', 'tranthib@gmail.com', '1998-08-20', 'Nữ', 'TP. Hồ Chí Minh'),
('UV003', 'TK004', 'Lê Văn', 'C', '0923456789', 'levanc@gmail.com', '1997-03-10', 'Nam', 'Đà Nẵng');

-- =============================================
-- 5. HỒ SƠ ỨNG VIÊN
-- =============================================
INSERT INTO HOSO (ID_HoSo, ID_UngVien, KyNang, KinhNghiem, HocVan, MucTieuNgheNghiep) VALUES
('HS001', 'UV001', 
 'PHP, MySQL, JavaScript, HTML/CSS, Laravel, Git', 
 '2 năm kinh nghiệm lập trình web tại công ty ABC',
 'Đại học Bách Khoa Hà Nội - Công nghệ thông tin',
 'Trở thành Senior Developer trong 3 năm tới'),
('HS002', 'UV002', 
 'Java, Spring Boot, MySQL, React, Docker', 
 '1 năm kinh nghiệm Full-stack Developer',
 'Đại học Khoa học Tự nhiên TP.HCM - CNTT',
 'Phát triển kỹ năng Backend và DevOps'),
('HS003', 'UV003', 
 'Python, Django, PostgreSQL, AWS, Machine Learning', 
 'Sinh viên mới tốt nghiệp, có 2 dự án cá nhân',
 'Đại học Đà Nẵng - Khoa học máy tính',
 'Làm việc trong lĩnh vực AI và Data Science');

-- =============================================
-- 6. NHÀ TUYỂN DỤNG
-- =============================================
INSERT INTO NHATUYENDUNG (ID_NhaTuyenDung, ID_TaiKhoan, Ten, MoTa, TrangWeb, DiaChi, SDT, Email, QuyMo, LinhVuc) VALUES
('NTD001', 'TK005', 'Công ty Cổ phần FPT', 
 'FPT là tập đoàn công nghệ hàng đầu Việt Nam với hơn 30 năm kinh nghiệm',
 'https://fpt.com.vn', 'Hà Nội', '0241234567', 'hr@fpt.com.vn', '10000+', 'Công nghệ thông tin'),
('NTD002', 'TK006', 'Tập đoàn Viễn thông Quân đội Viettel',
 'Viettel là tập đoàn viễn thông và công nghệ lớn nhất Việt Nam',
 'https://viettel.com.vn', 'Hà Nội', '0242345678', 'tuyendung@viettel.com.vn', '10000+', 'Viễn thông'),
('NTD003', 'TK007', 'Tập đoàn Vingroup',
 'Vingroup là tập đoàn kinh tế tư nhân đa ngành lớn nhất Việt Nam',
 'https://vingroup.net', 'Hà Nội', '0243456789', 'hr@vingroup.net', '10000+', 'Đa ngành');

-- =============================================
-- 7. BÀI ĐĂNG TUYỂN DỤNG
-- =============================================
INSERT INTO BAIDANG (ID_BaiDang, TieuDe, MoTa, YeuCau, MucLuong, MucLuongMax, LoaiLuong, DiaDiem, ID_NhaTuyenDung, LoaiCongViec, CapBac, KinhNghiem, SoLuong, TrangThai, NgayHetHan) VALUES
('BD001', 'PHP Developer (Laravel)', 
 'Phát triển và bảo trì các ứng dụng web sử dụng PHP/Laravel. Làm việc trong môi trường Agile, team trẻ trung năng động.',
 'Có ít nhất 1 năm kinh nghiệm PHP/Laravel\nThành thạo MySQL, Git\nBiết HTML, CSS, JavaScript\nƯu tiên biết Vue.js hoặc React',
 15000000, 25000000, 'Cố định', 'Hà Nội', 'NTD001', 'Full-time', 'Nhân viên', '1-2 năm', 3, 'active', DATE_ADD(NOW(), INTERVAL 30 DAY)),

('BD002', 'Senior Java Developer',
 'Tham gia phát triển các hệ thống lớn cho khách hàng doanh nghiệp. Làm việc với công nghệ Java, Spring Boot, Microservices.',
 'Tối thiểu 3 năm kinh nghiệm Java\nThành thạo Spring Framework, Spring Boot\nKinh nghiệm với Microservices, Docker, Kubernetes\nKỹ năng làm việc nhóm tốt',
 25000000, 40000000, 'Cố định', 'Hà Nội', 'NTD002', 'Full-time', 'Trưởng nhóm', '3-5 năm', 2, 'active', DATE_ADD(NOW(), INTERVAL 45 DAY)),

('BD003', 'Frontend Developer (React/Vue)',
 'Xây dựng giao diện người dùng cho các ứng dụng web và mobile. Làm việc với đội ngũ UX/UI designer chuyên nghiệp.',
 'Thành thạo HTML, CSS, JavaScript\nKinh nghiệm với React hoặc Vue.js\nBiết responsive design\nƯu tiên có kinh nghiệm TypeScript',
 12000000, 20000000, 'Cố định', 'TP. Hồ Chí Minh', 'NTD001', 'Full-time', 'Nhân viên', '1-3 năm', 5, 'active', DATE_ADD(NOW(), INTERVAL 30 DAY)),

('BD004', 'Data Scientist',
 'Phân tích dữ liệu lớn, xây dựng mô hình Machine Learning để tối ưu hóa dịch vụ viễn thông.',
 'Tốt nghiệp chuyên ngành liên quan đến Data Science, AI\nThành thạo Python, SQL\nKinh nghiệm với ML frameworks (TensorFlow, PyTorch)\nKỹ năng phân tích và trình bày dữ liệu',
 20000000, 35000000, 'Cố định', 'Hà Nội', 'NTD002', 'Full-time', 'Chuyên viên', '2-4 năm', 2, 'active', DATE_ADD(NOW(), INTERVAL 60 DAY)),

('BD005', 'Mobile Developer (iOS/Android)',
 'Phát triển ứng dụng di động cho hệ sinh thái Vingroup. Cơ hội làm việc với công nghệ mới nhất.',
 'Kinh nghiệm phát triển iOS (Swift) hoặc Android (Kotlin)\nHiểu biết về RESTful API\nƯu tiên biết Flutter hoặc React Native\nĐam mê công nghệ mobile',
 18000000, 30000000, 'Cố định', 'Hà Nội', 'NTD003', 'Full-time', 'Nhân viên', '2-3 năm', 4, 'active', DATE_ADD(NOW(), INTERVAL 30 DAY)),

('BD006', 'Thực tập sinh Lập trình Web',
 'Cơ hội thực tập cho sinh viên năm cuối. Được đào tạo bài bản, có cơ hội trở thành nhân viên chính thức.',
 'Sinh viên năm 3, 4 chuyên ngành CNTT\nCó kiến thức cơ bản về lập trình web\nHọc hỏi nhanh, nhiệt tình\nCó thể làm full-time trong thời gian thực tập',
 3000000, 5000000, 'Cố định', 'Hà Nội', 'NTD001', 'Thực tập', 'Thực tập sinh', 'Chưa có', 10, 'active', DATE_ADD(NOW(), INTERVAL 20 DAY)),

('BD007', 'DevOps Engineer',
 'Xây dựng và vận hành hạ tầng cloud, CI/CD pipeline cho các dự án lớn.',
 'Kinh nghiệm với AWS/Azure/GCP\nThành thạo Docker, Kubernetes\nBiết scripting (Bash, Python)\nKinh nghiệm CI/CD (Jenkins, GitLab CI)',
 22000000, 38000000, 'Cố định', 'TP. Hồ Chí Minh', 'NTD002', 'Full-time', 'Chuyên viên', '2-4 năm', 2, 'active', DATE_ADD(NOW(), INTERVAL 45 DAY)),

('BD008', 'UI/UX Designer',
 'Thiết kế giao diện và trải nghiệm người dùng cho các sản phẩm công nghệ của Vingroup.',
 'Thành thạo Figma, Adobe XD, Photoshop\nHiểu biết về UX research\nCó portfolio ấn tượng\nKỹ năng giao tiếp tốt',
 15000000, 25000000, 'Cố định', 'Hà Nội', 'NTD003', 'Full-time', 'Nhân viên', '1-3 năm', 3, 'active', DATE_ADD(NOW(), INTERVAL 30 DAY));

-- =============================================
-- 8. ĐƠN ỨNG TUYỂN MẪU
-- =============================================
INSERT INTO DONUNGTUYEN (ID_DonUngTuyen, ID_BaiDang, ID_UngVien, ThuXinViec, TrangThai) VALUES
('DUT001', 'BD001', 'UV001', 'Em rất quan tâm đến vị trí PHP Developer tại FPT. Em có 2 năm kinh nghiệm với Laravel và mong muốn được đóng góp cho công ty.', 'Đã xem'),
('DUT002', 'BD003', 'UV002', 'Em là một Frontend Developer với kinh nghiệm React. Em tin rằng em có thể đóng góp tích cực cho team.', 'Mới nộp'),
('DUT003', 'BD006', 'UV003', 'Em là sinh viên năm 4 và rất mong muốn được thực tập tại FPT để học hỏi kinh nghiệm thực tế.', 'Mời phỏng vấn');

-- =============================================
-- 9. VIỆC ĐÃ LƯU
-- =============================================
INSERT INTO LUUBAIDANG (ID_LuuCongViec, ID_UngVien, ID_BaiDang) VALUES
('LCV001', 'UV001', 'BD002'),
('LCV002', 'UV001', 'BD004'),
('LCV003', 'UV002', 'BD005'),
('LCV004', 'UV003', 'BD001');

-- =============================================
-- 10. THÔNG BÁO
-- =============================================
INSERT INTO THONGBAOUNGTUYEN (ID_ThongBao, ID_UngVien, ID_DonUngTuyen, TieuDe, NoiDung, LoaiThongBao, DaDoc) VALUES
('TB001', 'UV001', 'DUT001', 'Đơn ứng tuyển đã được xem', 'Nhà tuyển dụng đã xem hồ sơ của bạn cho vị trí PHP Developer.', 'Ứng tuyển', TRUE),
('TB002', 'UV003', 'DUT003', 'Mời phỏng vấn', 'Chúc mừng! Bạn đã được mời phỏng vấn cho vị trí Thực tập sinh. Vui lòng liên hệ: 0241234567', 'Phỏng vấn', FALSE),
('TB003', 'UV002', NULL, 'Chào mừng đến với Job Portal', 'Cảm ơn bạn đã đăng ký tài khoản. Hãy hoàn thiện hồ sơ để tăng cơ hội tìm việc!', 'Hệ thống', TRUE);

-- =============================================
-- 11. ĐÁNH GIÁ NHÀ TUYỂN DỤNG
-- =============================================
INSERT INTO DANHGIA (ID_DanhGia, ID_NhaTuyenDung, ID_UngVien, DiemDanhGia, NhanXet) VALUES
('DG001', 'NTD001', 'UV001', 5, 'Công ty rất chuyên nghiệp, quy trình tuyển dụng rõ ràng. Môi trường làm việc tốt.'),
('DG002', 'NTD002', 'UV002', 4, 'Lương thưởng hấp dẫn, nhiều cơ hội phát triển. Tuy nhiên áp lực công việc khá cao.');
