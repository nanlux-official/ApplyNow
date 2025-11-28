-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 28, 2025 lúc 03:40 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `job_portal`
--
CREATE DATABASE IF NOT EXISTS `job_portal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `job_portal`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baidang`
--

CREATE TABLE `baidang` (
  `ID_BaiDang` varchar(50) NOT NULL,
  `TieuDe` varchar(255) NOT NULL,
  `MoTa` longtext DEFAULT NULL,
  `YeuCau` longtext DEFAULT NULL,
  `MucLuong` decimal(15,2) DEFAULT NULL,
  `MucLuongMax` decimal(15,2) DEFAULT NULL,
  `LoaiLuong` enum('Thỏa thuận','Cố định','Theo giờ') DEFAULT 'Thỏa thuận',
  `DiaDiem` varchar(255) DEFAULT NULL,
  `ID_NhaTuyenDung` varchar(50) NOT NULL,
  `LoaiCongViec` enum('Full-time','Part-time','Thực tập','Freelance') DEFAULT 'Full-time',
  `CapBac` varchar(50) DEFAULT NULL,
  `KinhNghiem` varchar(50) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT 1,
  `TrangThai` enum('active','inactive','expired','hidden') DEFAULT 'active',
  `NgayDangTin` datetime DEFAULT current_timestamp(),
  `NgayHetHan` datetime DEFAULT NULL,
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LuotXem` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `baidang`
--

INSERT INTO `baidang` (`ID_BaiDang`, `TieuDe`, `MoTa`, `YeuCau`, `MucLuong`, `MucLuongMax`, `LoaiLuong`, `DiaDiem`, `ID_NhaTuyenDung`, `LoaiCongViec`, `CapBac`, `KinhNghiem`, `SoLuong`, `TrangThai`, `NgayDangTin`, `NgayHetHan`, `NgayCapNhat`, `LuotXem`) VALUES
('BD001', 'PHP Developer (Laravel)', 'Phát triển và bảo trì các ứng dụng web sử dụng PHP/Laravel. Làm việc trong môi trường Agile, team trẻ trung năng động.', 'Có ít nhất 1 năm kinh nghiệm PHP/Laravel\nThành thạo MySQL, Git\nBiết HTML, CSS, JavaScript\nƯu tiên biết Vue.js hoặc React', 15000000.00, 25000000.00, 'Cố định', 'Hà Nội', 'NTD001', 'Full-time', 'Nhân viên', '1-2 năm', 3, 'active', '2025-11-27 19:54:12', '2025-12-27 19:54:12', '2025-11-28 01:19:36', 26),
('BD002', 'Senior Java Developer', 'Tham gia phát triển các hệ thống lớn cho khách hàng doanh nghiệp. Làm việc với công nghệ Java, Spring Boot, Microservices.', 'Tối thiểu 3 năm kinh nghiệm Java\nThành thạo Spring Framework, Spring Boot\nKinh nghiệm với Microservices, Docker, Kubernetes\nKỹ năng làm việc nhóm tốt', 25000000.00, 40000000.00, 'Cố định', 'Hà Nội', 'NTD002', 'Full-time', 'Trưởng nhóm', '3-5 năm', 2, 'active', '2025-11-27 19:54:12', '2026-01-11 19:54:12', '2025-11-28 01:20:37', 15),
('BD003', 'Frontend Developer (React/Vue)', 'Xây dựng giao diện người dùng cho các ứng dụng web và mobile. Làm việc với đội ngũ UX/UI designer chuyên nghiệp.', 'Thành thạo HTML, CSS, JavaScript\nKinh nghiệm với React hoặc Vue.js\nBiết responsive design\nƯu tiên có kinh nghiệm TypeScript', 12000000.00, 20000000.00, 'Cố định', 'TP. Hồ Chí Minh', 'NTD001', 'Full-time', 'Nhân viên', '1-3 năm', 5, 'active', '2025-11-27 19:54:12', '2025-12-27 19:54:12', '2025-11-28 01:20:06', 12),
('BD004', 'Data Scientist', 'Phân tích dữ liệu lớn, xây dựng mô hình Machine Learning để tối ưu hóa dịch vụ viễn thông.', 'Tốt nghiệp chuyên ngành liên quan đến Data Science, AI\nThành thạo Python, SQL\nKinh nghiệm với ML frameworks (TensorFlow, PyTorch)\nKỹ năng phân tích và trình bày dữ liệu', 20000000.00, 35000000.00, 'Cố định', 'Hà Nội', 'NTD002', 'Full-time', 'Chuyên viên', '2-4 năm', 2, 'active', '2025-11-27 19:54:12', '2026-01-26 19:54:12', '2025-11-27 21:27:56', 1),
('BD006', 'Thực tập sinh Lập trình Web', 'Cơ hội thực tập cho sinh viên năm cuối. Được đào tạo bài bản, có cơ hội trở thành nhân viên chính thức.', 'Sinh viên năm 3, 4 chuyên ngành CNTT\nCó kiến thức cơ bản về lập trình web\nHọc hỏi nhanh, nhiệt tình\nCó thể làm full-time trong thời gian thực tập', 3000000.00, 5000000.00, 'Cố định', 'Hà Nội', 'NTD001', 'Thực tập', 'Thực tập sinh', 'Chưa có', 10, 'active', '2025-11-27 19:54:12', '2025-12-17 19:54:12', '2025-11-28 01:38:35', 8),
('BD007', 'DevOps Engineer', 'Xây dựng và vận hành hạ tầng cloud, CI/CD pipeline cho các dự án lớn.', 'Kinh nghiệm với AWS/Azure/GCP\nThành thạo Docker, Kubernetes\nBiết scripting (Bash, Python)\nKinh nghiệm CI/CD (Jenkins, GitLab CI)', 22000000.00, 38000000.00, 'Cố định', 'TP. Hồ Chí Minh', 'NTD002', 'Full-time', 'Chuyên viên', '2-4 năm', 2, 'active', '2025-11-27 19:54:12', '2026-01-11 19:54:12', '2025-11-28 01:38:31', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `ID_DanhGia` varchar(50) NOT NULL,
  `ID_NhaTuyenDung` varchar(50) NOT NULL,
  `ID_UngVien` varchar(50) NOT NULL,
  `DiemDanhGia` int(11) DEFAULT NULL CHECK (`DiemDanhGia` between 1 and 5),
  `NhanXet` longtext DEFAULT NULL,
  `NgayDanhGia` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`ID_DanhGia`, `ID_NhaTuyenDung`, `ID_UngVien`, `DiemDanhGia`, `NhanXet`, `NgayDanhGia`, `NgayCapNhat`) VALUES
('DG001', 'NTD001', 'UV001', 5, 'Công ty rất chuyên nghiệp, quy trình tuyển dụng rõ ràng. Môi trường làm việc tốt.', '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('DG002', 'NTD002', 'UV002', 4, 'Lương thưởng hấp dẫn, nhiều cơ hội phát triển. Tuy nhiên áp lực công việc khá cao.', '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('DG692896702FA97', 'NTD002', 'UV001', 3, 's', '2025-11-28 01:20:32', '2025-11-28 01:20:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donungtuyen`
--

CREATE TABLE `donungtuyen` (
  `ID_DonUngTuyen` varchar(50) NOT NULL,
  `ID_BaiDang` varchar(50) NOT NULL,
  `ID_UngVien` varchar(50) NOT NULL,
  `FileCV` varchar(255) DEFAULT NULL,
  `ThuXinViec` text DEFAULT NULL,
  `TrangThai` enum('Mới nộp','Đã xem','Mời phỏng vấn','Từ chối','Trúng tuyển') DEFAULT 'Mới nộp',
  `NgayUngTuyen` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donungtuyen`
--

INSERT INTO `donungtuyen` (`ID_DonUngTuyen`, `ID_BaiDang`, `ID_UngVien`, `FileCV`, `ThuXinViec`, `TrangThai`, `NgayUngTuyen`, `NgayCapNhat`) VALUES
('DUT692866CB3D4F3', 'BD001', 'UV001', '692866cb3cef5_1764255435.docx', 'đấ', 'Đã xem', '2025-11-27 21:57:15', '2025-11-27 21:58:37'),
('DUT6928965690D87', 'BD003', 'UV001', '6928965690845_1764267606.docx', 'ok', 'Mới nộp', '2025-11-28 01:20:06', '2025-11-28 01:20:06'),
('DUT6928966B8C0AB', 'BD002', 'UV001', '6928966b8bd92_1764267627.docx', 'xxxx', 'Mới nộp', '2025-11-28 01:20:27', '2025-11-28 01:20:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoso`
--

CREATE TABLE `hoso` (
  `ID_HoSo` varchar(50) NOT NULL,
  `ID_UngVien` varchar(50) NOT NULL,
  `KyNang` text DEFAULT NULL,
  `KinhNghiem` text DEFAULT NULL,
  `HocVan` text DEFAULT NULL,
  `ChungChi` text DEFAULT NULL,
  `MucTieuNgheNghiep` text DEFAULT NULL,
  `FileCV` varchar(255) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoso`
--

INSERT INTO `hoso` (`ID_HoSo`, `ID_UngVien`, `KyNang`, `KinhNghiem`, `HocVan`, `ChungChi`, `MucTieuNgheNghiep`, `FileCV`, `NgayTao`, `NgayCapNhat`) VALUES
('HS001', 'UV001', 'PHP, MySQL, JavaScript, HTML/CSS, Laravel, Git', '2 năm kinh nghiệm lập trình web tại công ty ABC', 'Đại học Bách Khoa Hà Nội - Công nghệ thông tin', NULL, 'Trở thành Senior Developer trong 3 năm tới', NULL, '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('HS002', 'UV002', 'Java, Spring Boot, MySQL, React, Docker', '1 năm kinh nghiệm Full-stack Developer', 'Đại học Khoa học Tự nhiên TP.HCM - CNTT', NULL, 'Phát triển kỹ năng Backend và DevOps', NULL, '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('HS003', 'UV003', 'Python, Django, PostgreSQL, AWS, Machine Learning', 'Sinh viên mới tốt nghiệp, có 2 dự án cá nhân', 'Đại học Đà Nẵng - Khoa học máy tính', NULL, 'Làm việc trong lĩnh vực AI và Data Science', NULL, '2025-11-27 19:54:12', '2025-11-27 19:54:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luubaidang`
--

CREATE TABLE `luubaidang` (
  `ID_LuuCongViec` varchar(50) NOT NULL,
  `ID_UngVien` varchar(50) NOT NULL,
  `ID_BaiDang` varchar(50) NOT NULL,
  `NgayLuu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `luubaidang`
--

INSERT INTO `luubaidang` (`ID_LuuCongViec`, `ID_UngVien`, `ID_BaiDang`, `NgayLuu`) VALUES
('LCV001', 'UV001', 'BD002', '2025-11-27 19:54:12'),
('LCV002', 'UV001', 'BD004', '2025-11-27 19:54:12'),
('LCV004', 'UV003', 'BD001', '2025-11-27 19:54:12'),
('LCV69285FE610842', 'UV001', 'BD003', '2025-11-27 21:27:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhatuyendung`
--

CREATE TABLE `nhatuyendung` (
  `ID_NhaTuyenDung` varchar(50) NOT NULL,
  `ID_TaiKhoan` varchar(50) NOT NULL,
  `Ten` varchar(255) NOT NULL,
  `MoTa` longtext DEFAULT NULL,
  `TrangWeb` varchar(255) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Logo` varchar(255) DEFAULT NULL,
  `QuyMo` varchar(50) DEFAULT NULL,
  `LinhVuc` varchar(100) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhatuyendung`
--

INSERT INTO `nhatuyendung` (`ID_NhaTuyenDung`, `ID_TaiKhoan`, `Ten`, `MoTa`, `TrangWeb`, `DiaChi`, `SDT`, `Email`, `Logo`, `QuyMo`, `LinhVuc`, `NgayTao`, `NgayCapNhat`) VALUES
('NTD001', 'TK005', 'HDA Concept', 'Công ty', 'https://hdaconcept.com', '01 Võ An Ninh, Hòa Xuân, Cẩm Lệ', '0704623994', 'hdadesign@hdaconcept.com', 'logo_NTD001_1764266028.jpg', '1-50', 'Thiết Kế Nội Thất', '2025-11-27 19:54:12', '2025-11-28 00:58:13'),
('NTD002', 'TK006', 'Tập đoàn Viễn thông Quân đội Viettel', 'Viettel là tập đoàn viễn thông và công nghệ lớn nhất Việt Nam', 'https://viettel.com.vn', 'Hà Nội', '0242345678', 'tuyendung@viettel.com.vn', NULL, '10000+', 'Viễn thông', '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('NTD6928898B7498E', 'TK002', 'Chưa cập nhật', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 00:25:31', '2025-11-28 00:25:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanlybaidang`
--

CREATE TABLE `quanlybaidang` (
  `ID_QuanLy` varchar(50) NOT NULL,
  `ID_BaiDang` varchar(50) NOT NULL,
  `ID_NhaTuyenDung` varchar(50) NOT NULL,
  `ID_Admin` varchar(50) DEFAULT NULL,
  `HanhDong` varchar(100) NOT NULL,
  `LyDo` text DEFAULT NULL,
  `ThoiGian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanlytaikhoancanhan`
--

CREATE TABLE `quanlytaikhoancanhan` (
  `ID_QuanLyTaiKhoan` varchar(50) NOT NULL,
  `ID_TaiKhoan` varchar(50) NOT NULL,
  `LoaiNguoiDung` enum('Ứng viên','Nhà tuyển dụng','Admin') NOT NULL,
  `ThongTinTaiKhoan` longtext DEFAULT NULL,
  `HanhDong` varchar(100) DEFAULT NULL,
  `NgayCapNhat` datetime DEFAULT current_timestamp(),
  `NguoiCapNhat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quanlytaikhoancanhan`
--

INSERT INTO `quanlytaikhoancanhan` (`ID_QuanLyTaiKhoan`, `ID_TaiKhoan`, `LoaiNguoiDung`, `ThongTinTaiKhoan`, `HanhDong`, `NgayCapNhat`, `NguoiCapNhat`) VALUES
('QLTK69285101A7FF0', 'TK005', '', 'Trạng thái: locked', 'Khóa tài khoản', '2025-11-27 20:24:17', 'TK001'),
('QLTK692851045A3C2', 'TK005', '', 'Trạng thái: active', 'Mở khóa tài khoản', '2025-11-27 20:24:20', 'TK001'),
('QLTK6928540C76874', 'TK002', '', 'Email: nguyenvana@gmail.comm, Trạng thái: active. Ghi chú: ', 'Cập nhật tài khoản', '2025-11-27 20:37:16', 'TK001'),
('QLTK692854184CEF5', 'TK002', '', 'Email: nguyenvana@gmail.com, Trạng thái: active. Ghi chú: ', 'Cập nhật tài khoản', '2025-11-27 20:37:28', 'TK001');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_tickets`
--

CREATE TABLE `support_tickets` (
  `ID_Ticket` varchar(50) NOT NULL,
  `ID_NguoiDung` varchar(50) NOT NULL,
  `LoaiNguoiDung` enum('APPLICANT','EMPLOYER') NOT NULL,
  `TieuDe` varchar(255) NOT NULL,
  `NoiDung` text NOT NULL,
  `TrangThai` varchar(50),
  `DoUuTien` varchar(50),
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NguoiXuLy` varchar(50) DEFAULT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `support_tickets`
--

INSERT INTO `support_tickets` (`ID_Ticket`, `ID_NguoiDung`, `LoaiNguoiDung`, `TieuDe`, `NoiDung`, `TrangThai`, `DoUuTien`, `NgayTao`, `NgayCapNhat`, `NguoiXuLy`, `GhiChu`) VALUES
('TK6928841924EBC', 'UV001', 'APPLICANT', 'Tôi yêu cầu trở', 'kkkkkkkkkkkkk', 'M?i', 'Trung bình', '2025-11-28 00:02:17', '2025-11-28 00:02:17', NULL, NULL),
('TK6928847D9E6EB', 'UV001', 'APPLICANT', 'Tôi yêu cầu trở thành nhà tuyển dụng', 'p', 'Đã giải quyết', 'Trung bình', '2025-11-28 00:03:57', '2025-11-28 00:08:48', 'TK001', ''),
('TK6928871C48D1D', 'UV001', 'APPLICANT', '🏢 Yêu cầu nâng cấp lên Nhà tuyển dụng - ss', '=== YÊU CẦU NÂNG CẤP LÊN NHÀ TUYỂN DỤNG ===\n\nTHÔNG TIN CÔNG TY:\n- Tên công ty: ss\n- Mã số thuế: 09876543565\n- Địa chỉ: dđ\n- Số điện thoại: 0987654323\n- Email công ty: d@gmail.com\n- Website: https://faceobok.com\n- Quy mô: 51-200\n- Lĩnh vực: d\n\nMÔ TẢ CÔNG TY:\nd\n\nLÝ DO:\nd', 'Đã giải quyết', 'Cao', '2025-11-28 00:15:08', '2025-11-28 00:15:27', 'TK001', 'okkkk');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `ID_TaiKhoan` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `TrangThai` enum('active','inactive','locked') DEFAULT 'inactive',
  `TokenXacThuc` varchar(255) DEFAULT NULL,
  `TokenResetPass` varchar(255) DEFAULT NULL,
  `TokenExpiry` datetime DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`ID_TaiKhoan`, `Email`, `Pass`, `TrangThai`, `TokenXacThuc`, `TokenResetPass`, `TokenExpiry`, `NgayTao`, `NgayCapNhat`) VALUES
('TK001', 'admin@jobportal.com', '$2y$10$BMXON9Dt.Q9Frw62yCNXL.DZdIpLLqStb2.aKbRV0B5oCgpAWtt/a', 'active', NULL, NULL, NULL, '2025-11-27 19:54:12', '2025-11-27 20:11:08'),
('TK002', 'nguyenvana@gmail.com', '$2y$10$BMXON9Dt.Q9Frw62yCNXL.DZdIpLLqStb2.aKbRV0B5oCgpAWtt/a', 'active', NULL, NULL, NULL, '2025-11-27 19:54:12', '2025-11-27 20:37:28'),
('TK003', 'tranthib@gmail.com', '$2y$10$BMXON9Dt.Q9Frw62yCNXL.DZdIpLLqStb2.aKbRV0B5oCgpAWtt/a', 'active', NULL, NULL, NULL, '2025-11-27 19:54:12', '2025-11-27 20:11:08'),
('TK004', 'levanc@gmail.com', '$2y$10$BMXON9Dt.Q9Frw62yCNXL.DZdIpLLqStb2.aKbRV0B5oCgpAWtt/a', 'active', NULL, NULL, NULL, '2025-11-27 19:54:12', '2025-11-27 20:11:08'),
('TK005', 'hr@fpt.com.vn', '$2y$10$OE03IZxNeE.zKszDoDLlAOx6z2BF2GRpslzlJ54d8B6I.lYO8O0L.', 'active', NULL, NULL, NULL, '2025-11-27 19:54:12', '2025-11-28 00:30:41'),
('TK006', 'tuyendung@viettel.com.vn', '$2y$10$BMXON9Dt.Q9Frw62yCNXL.DZdIpLLqStb2.aKbRV0B5oCgpAWtt/a', 'active', NULL, NULL, NULL, '2025-11-27 19:54:12', '2025-11-27 20:11:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoanvaitro`
--

CREATE TABLE `taikhoanvaitro` (
  `ID` varchar(50) NOT NULL,
  `ID_TaiKhoan` varchar(50) NOT NULL,
  `ID_VaiTro` varchar(50) NOT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoanvaitro`
--

INSERT INTO `taikhoanvaitro` (`ID`, `ID_TaiKhoan`, `ID_VaiTro`, `NgayTao`) VALUES
('', 'TK002', 'VT001', '2025-11-28 00:25:50'),
('TKVT001', 'TK001', 'VT003', '2025-11-27 19:54:12'),
('TKVT003', 'TK003', 'VT001', '2025-11-27 19:54:12'),
('TKVT004', 'TK004', 'VT001', '2025-11-27 19:54:12'),
('TKVT005', 'TK005', 'VT002', '2025-11-27 19:54:12'),
('TKVT006', 'TK006', 'VT002', '2025-11-27 19:54:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbaoungtuyen`
--

CREATE TABLE `thongbaoungtuyen` (
  `ID_ThongBao` varchar(50) NOT NULL,
  `ID_UngVien` varchar(50) NOT NULL,
  `ID_DonUngTuyen` varchar(50) DEFAULT NULL,
  `TieuDe` varchar(255) NOT NULL,
  `NoiDung` text DEFAULT NULL,
  `LoaiThongBao` enum('Hệ thống','Ứng tuyển','Phỏng vấn','Kết quả') DEFAULT 'Hệ thống',
  `DaDoc` tinyint(1) DEFAULT 0,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thongbaoungtuyen`
--

INSERT INTO `thongbaoungtuyen` (`ID_ThongBao`, `ID_UngVien`, `ID_DonUngTuyen`, `TieuDe`, `NoiDung`, `LoaiThongBao`, `DaDoc`, `NgayTao`) VALUES
('TB001', 'UV001', NULL, 'Đơn ứng tuyển đã được xem', 'Nhà tuyển dụng đã xem hồ sơ của bạn cho vị trí PHP Developer.', 'Ứng tuyển', 1, '2025-11-27 19:54:12'),
('TB002', 'UV003', NULL, 'Mời phỏng vấn', 'Chúc mừng! Bạn đã được mời phỏng vấn cho vị trí Thực tập sinh. Vui lòng liên hệ: 0241234567', 'Phỏng vấn', 0, '2025-11-27 19:54:12'),
('TB003', 'UV002', NULL, 'Chào mừng đến với Job Portal', 'Cảm ơn bạn đã đăng ký tài khoản. Hãy hoàn thiện hồ sơ để tăng cơ hội tìm việc!', 'Hệ thống', 1, '2025-11-27 19:54:12'),
('TB69285ACF3BC62', 'UV002', NULL, 'Chúc mừng! Bạn đã trúng tuyển', 'Đơn ứng tuyển của bạn cho vị trí \"Frontend Developer (React/Vue)\" tại Công ty Cổ phần FPT đã được cập nhật: Trúng tuyển', 'Ứng tuyển', 0, '2025-11-27 21:06:07'),
('TB6928615A7454B', 'UV001', NULL, 'Rất tiếc, hồ sơ của bạn chưa phù hợp lần này', 'Đơn ứng tuyển của bạn cho vị trí \"Frontend Developer (React/Vue)\" tại Công ty Cổ phần FPT đã được cập nhật: Từ chối', 'Ứng tuyển', 0, '2025-11-27 21:34:02'),
('TB6928618EAF11B', 'UV001', NULL, 'Nhà tuyển dụng đã xem hồ sơ của bạn', 'Đơn ứng tuyển của bạn cho vị trí \"Frontend Developer (React/Vue)\" tại Công ty Cổ phần FPT đã được cập nhật: Đã xem', 'Ứng tuyển', 0, '2025-11-27 21:34:54'),
('TB6928618EAF863', 'UV001', NULL, 'Thông báo từ nhà tuyển dụng', 'ok', 'Ứng tuyển', 0, '2025-11-27 21:34:54'),
('TB692866250FF2D', 'UV001', NULL, 'Chúc mừng! Bạn đã được mời phỏng vấn', 'Đơn ứng tuyển của bạn cho vị trí \"PHP Developer (Laravel)\" tại Công ty Cổ phần FPT đã được cập nhật: Mời phỏng vấn', 'Ứng tuyển', 0, '2025-11-27 21:54:29'),
('TB69286625104D6', 'UV001', NULL, 'Thông báo từ nhà tuyển dụng', 'sdasd', 'Ứng tuyển', 0, '2025-11-27 21:54:29'),
('TB692866D3D35D4', 'UV001', 'DUT692866CB3D4F3', 'Chúc mừng! Bạn đã trúng tuyển', 'Đơn ứng tuyển của bạn cho vị trí \"PHP Developer (Laravel)\" đã được cập nhật: Trúng tuyển\n\n📝 Thông báo từ nhà tuyển dụng:\nsdasdas', 'Ứng tuyển', 0, '2025-11-27 21:57:23'),
('TB6928671D488BF', 'UV001', 'DUT692866CB3D4F3', 'Nhà tuyển dụng đã xem hồ sơ của bạn', 'Đơn ứng tuyển của bạn cho vị trí \"PHP Developer (Laravel)\" đã được cập nhật: Đã xem', 'Ứng tuyển', 0, '2025-11-27 21:58:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `ID_Reply` varchar(50) NOT NULL,
  `ID_Ticket` varchar(50) NOT NULL,
  `ID_NguoiGui` varchar(50) NOT NULL,
  `LoaiNguoiGui` varchar(20) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_replies`
--

INSERT INTO `ticket_replies` (`ID_Reply`, `ID_Ticket`, `ID_NguoiGui`, `LoaiNguoiGui`, `NoiDung`, `NgayTao`) VALUES
('RP69288732B1A29', 'TK6928871C48D1D', 'TK001', 'ADMIN', 'ok', '2025-11-28 00:15:30'),
('RP692887984910D', 'TK6928871C48D1D', 'TK002', 'USER', 'ok', '2025-11-28 00:17:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ungvien`
--

CREATE TABLE `ungvien` (
  `ID_UngVien` varchar(50) NOT NULL,
  `ID_TaiKhoan` varchar(50) NOT NULL,
  `HoLot` varchar(100) DEFAULT NULL,
  `Ten` varchar(50) NOT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `NgaySinh` date DEFAULT NULL,
  `GioiTinh` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `AnhDaiDien` varchar(255) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ungvien`
--

INSERT INTO `ungvien` (`ID_UngVien`, `ID_TaiKhoan`, `HoLot`, `Ten`, `SDT`, `Email`, `NgaySinh`, `GioiTinh`, `DiaChi`, `AnhDaiDien`, `NgayTao`, `NgayCapNhat`) VALUES
('UV001', 'TK002', 'Nguyễn Văn', 'Nam', '0901234567', 'nguyenvana@gmail.com', '1995-05-15', 'Nam', 'Hà Nội', NULL, '2025-11-27 19:54:12', '2025-11-27 21:24:46'),
('UV002', 'TK003', 'Trần Thị', 'B', '0912345678', 'tranthib@gmail.com', '1998-08-20', 'Nữ', 'TP. Hồ Chí Minh', NULL, '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('UV003', 'TK004', 'Lê Văn', 'C', '0923456789', 'levanc@gmail.com', '1997-03-10', 'Nam', 'Đà Nẵng', NULL, '2025-11-27 19:54:12', '2025-11-27 19:54:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro`
--

CREATE TABLE `vaitro` (
  `ID_VaiTro` varchar(50) NOT NULL,
  `Ten` varchar(50) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vaitro`
--

INSERT INTO `vaitro` (`ID_VaiTro`, `Ten`, `MoTa`, `NgayTao`, `NgayCapNhat`) VALUES
('VT001', 'APPLICANT', 'Ứng viên tìm việc', '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('VT002', 'EMPLOYER', 'Nhà tuyển dụng', '2025-11-27 19:54:12', '2025-11-27 19:54:12'),
('VT003', 'ADMIN', 'Quản trị viên hệ thống', '2025-11-27 19:54:12', '2025-11-27 19:54:12');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baidang`
--
ALTER TABLE `baidang`
  ADD PRIMARY KEY (`ID_BaiDang`),
  ADD KEY `idx_nhatuyendung` (`ID_NhaTuyenDung`),
  ADD KEY `idx_diadiem` (`DiaDiem`),
  ADD KEY `idx_loaicongviec` (`LoaiCongViec`),
  ADD KEY `idx_trangthai` (`TrangThai`),
  ADD KEY `idx_ngaydangtin` (`NgayDangTin`);
ALTER TABLE `baidang` ADD FULLTEXT KEY `idx_fulltext` (`TieuDe`,`MoTa`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`ID_DanhGia`),
  ADD UNIQUE KEY `unique_review` (`ID_NhaTuyenDung`,`ID_UngVien`),
  ADD KEY `idx_nhatuyendung` (`ID_NhaTuyenDung`),
  ADD KEY `idx_ungvien` (`ID_UngVien`);

--
-- Chỉ mục cho bảng `donungtuyen`
--
ALTER TABLE `donungtuyen`
  ADD PRIMARY KEY (`ID_DonUngTuyen`),
  ADD UNIQUE KEY `unique_application` (`ID_BaiDang`,`ID_UngVien`),
  ADD KEY `idx_baidang` (`ID_BaiDang`),
  ADD KEY `idx_ungvien` (`ID_UngVien`),
  ADD KEY `idx_trangthai` (`TrangThai`),
  ADD KEY `idx_ngayungtuyen` (`NgayUngTuyen`);

--
-- Chỉ mục cho bảng `hoso`
--
ALTER TABLE `hoso`
  ADD PRIMARY KEY (`ID_HoSo`),
  ADD KEY `idx_ungvien` (`ID_UngVien`);

--
-- Chỉ mục cho bảng `luubaidang`
--
ALTER TABLE `luubaidang`
  ADD PRIMARY KEY (`ID_LuuCongViec`),
  ADD UNIQUE KEY `unique_save` (`ID_UngVien`,`ID_BaiDang`),
  ADD KEY `idx_ungvien` (`ID_UngVien`),
  ADD KEY `idx_baidang` (`ID_BaiDang`);

--
-- Chỉ mục cho bảng `nhatuyendung`
--
ALTER TABLE `nhatuyendung`
  ADD PRIMARY KEY (`ID_NhaTuyenDung`),
  ADD UNIQUE KEY `ID_TaiKhoan` (`ID_TaiKhoan`),
  ADD KEY `idx_ten` (`Ten`),
  ADD KEY `idx_linhvuc` (`LinhVuc`);

--
-- Chỉ mục cho bảng `quanlybaidang`
--
ALTER TABLE `quanlybaidang`
  ADD PRIMARY KEY (`ID_QuanLy`),
  ADD KEY `ID_Admin` (`ID_Admin`),
  ADD KEY `idx_baidang` (`ID_BaiDang`),
  ADD KEY `idx_nhatuyendung` (`ID_NhaTuyenDung`),
  ADD KEY `idx_thoigian` (`ThoiGian`);

--
-- Chỉ mục cho bảng `quanlytaikhoancanhan`
--
ALTER TABLE `quanlytaikhoancanhan`
  ADD PRIMARY KEY (`ID_QuanLyTaiKhoan`),
  ADD KEY `idx_taikhoan` (`ID_TaiKhoan`),
  ADD KEY `idx_ngaycapnhat` (`NgayCapNhat`);

--
-- Chỉ mục cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ID_Ticket`),
  ADD KEY `idx_nguoidung` (`ID_NguoiDung`),
  ADD KEY `idx_trangthai` (`TrangThai`),
  ADD KEY `idx_ngaytao` (`NgayTao`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`ID_TaiKhoan`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `idx_email` (`Email`),
  ADD KEY `idx_token` (`TokenXacThuc`),
  ADD KEY `idx_reset_token` (`TokenResetPass`);

--
-- Chỉ mục cho bảng `taikhoanvaitro`
--
ALTER TABLE `taikhoanvaitro`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_user_role` (`ID_TaiKhoan`,`ID_VaiTro`),
  ADD KEY `idx_taikhoan` (`ID_TaiKhoan`),
  ADD KEY `idx_vaitro` (`ID_VaiTro`);

--
-- Chỉ mục cho bảng `thongbaoungtuyen`
--
ALTER TABLE `thongbaoungtuyen`
  ADD PRIMARY KEY (`ID_ThongBao`),
  ADD KEY `ID_DonUngTuyen` (`ID_DonUngTuyen`),
  ADD KEY `idx_ungvien` (`ID_UngVien`),
  ADD KEY `idx_dadoc` (`DaDoc`),
  ADD KEY `idx_ngaytao` (`NgayTao`);

--
-- Chỉ mục cho bảng `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`ID_Reply`),
  ADD KEY `idx_ticket` (`ID_Ticket`),
  ADD KEY `idx_ngaytao` (`NgayTao`);

--
-- Chỉ mục cho bảng `ungvien`
--
ALTER TABLE `ungvien`
  ADD PRIMARY KEY (`ID_UngVien`),
  ADD UNIQUE KEY `ID_TaiKhoan` (`ID_TaiKhoan`),
  ADD KEY `idx_email` (`Email`),
  ADD KEY `idx_ten` (`Ten`);

--
-- Chỉ mục cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`ID_VaiTro`),
  ADD UNIQUE KEY `Ten` (`Ten`),
  ADD KEY `idx_ten` (`Ten`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baidang`
--
ALTER TABLE `baidang`
  ADD CONSTRAINT `baidang_ibfk_1` FOREIGN KEY (`ID_NhaTuyenDung`) REFERENCES `nhatuyendung` (`ID_NhaTuyenDung`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`ID_NhaTuyenDung`) REFERENCES `nhatuyendung` (`ID_NhaTuyenDung`) ON DELETE CASCADE,
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`ID_UngVien`) REFERENCES `ungvien` (`ID_UngVien`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donungtuyen`
--
ALTER TABLE `donungtuyen`
  ADD CONSTRAINT `donungtuyen_ibfk_1` FOREIGN KEY (`ID_BaiDang`) REFERENCES `baidang` (`ID_BaiDang`) ON DELETE CASCADE,
  ADD CONSTRAINT `donungtuyen_ibfk_2` FOREIGN KEY (`ID_UngVien`) REFERENCES `ungvien` (`ID_UngVien`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hoso`
--
ALTER TABLE `hoso`
  ADD CONSTRAINT `hoso_ibfk_1` FOREIGN KEY (`ID_UngVien`) REFERENCES `ungvien` (`ID_UngVien`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `luubaidang`
--
ALTER TABLE `luubaidang`
  ADD CONSTRAINT `luubaidang_ibfk_1` FOREIGN KEY (`ID_UngVien`) REFERENCES `ungvien` (`ID_UngVien`) ON DELETE CASCADE,
  ADD CONSTRAINT `luubaidang_ibfk_2` FOREIGN KEY (`ID_BaiDang`) REFERENCES `baidang` (`ID_BaiDang`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nhatuyendung`
--
ALTER TABLE `nhatuyendung`
  ADD CONSTRAINT `nhatuyendung_ibfk_1` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `quanlybaidang`
--
ALTER TABLE `quanlybaidang`
  ADD CONSTRAINT `quanlybaidang_ibfk_1` FOREIGN KEY (`ID_BaiDang`) REFERENCES `baidang` (`ID_BaiDang`) ON DELETE CASCADE,
  ADD CONSTRAINT `quanlybaidang_ibfk_2` FOREIGN KEY (`ID_NhaTuyenDung`) REFERENCES `nhatuyendung` (`ID_NhaTuyenDung`) ON DELETE CASCADE,
  ADD CONSTRAINT `quanlybaidang_ibfk_3` FOREIGN KEY (`ID_Admin`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `quanlytaikhoancanhan`
--
ALTER TABLE `quanlytaikhoancanhan`
  ADD CONSTRAINT `quanlytaikhoancanhan_ibfk_1` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `taikhoanvaitro`
--
ALTER TABLE `taikhoanvaitro`
  ADD CONSTRAINT `taikhoanvaitro_ibfk_1` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE,
  ADD CONSTRAINT `taikhoanvaitro_ibfk_2` FOREIGN KEY (`ID_VaiTro`) REFERENCES `vaitro` (`ID_VaiTro`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thongbaoungtuyen`
--
ALTER TABLE `thongbaoungtuyen`
  ADD CONSTRAINT `thongbaoungtuyen_ibfk_1` FOREIGN KEY (`ID_UngVien`) REFERENCES `ungvien` (`ID_UngVien`) ON DELETE CASCADE,
  ADD CONSTRAINT `thongbaoungtuyen_ibfk_2` FOREIGN KEY (`ID_DonUngTuyen`) REFERENCES `donungtuyen` (`ID_DonUngTuyen`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_ibfk_1` FOREIGN KEY (`ID_Ticket`) REFERENCES `support_tickets` (`ID_Ticket`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `ungvien`
--
ALTER TABLE `ungvien`
  ADD CONSTRAINT `ungvien_ibfk_1` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
