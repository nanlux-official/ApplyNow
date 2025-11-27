-- =============================================
-- JOB PORTAL DATABASE SCHEMA
-- =============================================

DROP DATABASE IF EXISTS job_portal;
CREATE DATABASE job_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE job_portal;

-- =============================================
-- 1. BẢNG VAI TRÒ (ROLES)
-- =============================================
CREATE TABLE VAITRO (
    ID_VaiTro VARCHAR(50) PRIMARY KEY,
    Ten VARCHAR(50) NOT NULL UNIQUE,
    MoTa TEXT,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_ten (Ten)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. BẢNG TÀI KHOẢN
-- =============================================
CREATE TABLE TAIKHOAN (
    ID_TaiKhoan VARCHAR(50) PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Pass VARCHAR(255) NOT NULL,
    TrangThai ENUM('active', 'inactive', 'locked') DEFAULT 'inactive',
    TokenXacThuc VARCHAR(255),
    TokenResetPass VARCHAR(255),
    TokenExpiry DATETIME,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (Email),
    INDEX idx_token (TokenXacThuc),
    INDEX idx_reset_token (TokenResetPass)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 3. BẢNG TÀI KHOẢN - VAI TRÒ (Many-to-Many)
-- =============================================
CREATE TABLE TAIKHOANVAITRO (
    ID VARCHAR(50) PRIMARY KEY,
    ID_TaiKhoan VARCHAR(50) NOT NULL,
    ID_VaiTro VARCHAR(50) NOT NULL,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_TaiKhoan) REFERENCES TAIKHOAN(ID_TaiKhoan) ON DELETE CASCADE,
    FOREIGN KEY (ID_VaiTro) REFERENCES VAITRO(ID_VaiTro) ON DELETE CASCADE,
    UNIQUE KEY unique_user_role (ID_TaiKhoan, ID_VaiTro),
    INDEX idx_taikhoan (ID_TaiKhoan),
    INDEX idx_vaitro (ID_VaiTro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 4. BẢNG ỨNG VIÊN
-- =============================================
CREATE TABLE UNGVIEN (
    ID_UngVien VARCHAR(50) PRIMARY KEY,
    ID_TaiKhoan VARCHAR(50) NOT NULL UNIQUE,
    HoLot VARCHAR(100),
    Ten VARCHAR(50) NOT NULL,
    SDT VARCHAR(20),
    Email VARCHAR(255) NOT NULL,
    NgaySinh DATE,
    GioiTinh ENUM('Nam', 'Nữ', 'Khác'),
    DiaChi VARCHAR(255),
    AnhDaiDien VARCHAR(255),
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_TaiKhoan) REFERENCES TAIKHOAN(ID_TaiKhoan) ON DELETE CASCADE,
    INDEX idx_email (Email),
    INDEX idx_ten (Ten)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 5. BẢNG HỒ SƠ ỨNG VIÊN
-- =============================================
CREATE TABLE HOSO (
    ID_HoSo VARCHAR(50) PRIMARY KEY,
    ID_UngVien VARCHAR(50) NOT NULL,
    KyNang TEXT,
    KinhNghiem TEXT,
    HocVan TEXT,
    ChungChi TEXT,
    MucTieuNgheNghiep TEXT,
    FileCV VARCHAR(255),
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_UngVien) REFERENCES UNGVIEN(ID_UngVien) ON DELETE CASCADE,
    INDEX idx_ungvien (ID_UngVien)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 6. BẢNG NHÀ TUYỂN DỤNG
-- =============================================
CREATE TABLE NHATUYENDUNG (
    ID_NhaTuyenDung VARCHAR(50) PRIMARY KEY,
    ID_TaiKhoan VARCHAR(50) NOT NULL UNIQUE,
    Ten VARCHAR(255) NOT NULL,
    MoTa LONGTEXT,
    TrangWeb VARCHAR(255),
    DiaChi VARCHAR(255),
    SDT VARCHAR(20),
    Email VARCHAR(255),
    Logo VARCHAR(255),
    QuyMo VARCHAR(50),
    LinhVuc VARCHAR(100),
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_TaiKhoan) REFERENCES TAIKHOAN(ID_TaiKhoan) ON DELETE CASCADE,
    INDEX idx_ten (Ten),
    INDEX idx_linhvuc (LinhVuc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 7. BẢNG BÀI ĐĂNG TUYỂN DỤNG
-- =============================================
CREATE TABLE BAIDANG (
    ID_BaiDang VARCHAR(50) PRIMARY KEY,
    TieuDe VARCHAR(255) NOT NULL,
    MoTa LONGTEXT,
    YeuCau LONGTEXT,
    MucLuong DECIMAL(15,2),
    MucLuongMax DECIMAL(15,2),
    LoaiLuong ENUM('Thỏa thuận', 'Cố định', 'Theo giờ') DEFAULT 'Thỏa thuận',
    DiaDiem VARCHAR(255),
    ID_NhaTuyenDung VARCHAR(50) NOT NULL,
    LoaiCongViec ENUM('Full-time', 'Part-time', 'Thực tập', 'Freelance') DEFAULT 'Full-time',
    CapBac VARCHAR(50),
    KinhNghiem VARCHAR(50),
    SoLuong INT DEFAULT 1,
    TrangThai ENUM('active', 'inactive', 'expired', 'hidden') DEFAULT 'active',
    NgayDangTin DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayHetHan DATETIME,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    LuotXem INT DEFAULT 0,
    FOREIGN KEY (ID_NhaTuyenDung) REFERENCES NHATUYENDUNG(ID_NhaTuyenDung) ON DELETE CASCADE,
    INDEX idx_nhatuyendung (ID_NhaTuyenDung),
    INDEX idx_diadiem (DiaDiem),
    INDEX idx_loaicongviec (LoaiCongViec),
    INDEX idx_trangthai (TrangThai),
    INDEX idx_ngaydangtin (NgayDangTin),
    FULLTEXT idx_fulltext (TieuDe, MoTa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 8. BẢNG LƯU BÀI ĐĂNG (Saved Jobs)
-- =============================================
CREATE TABLE LUUBAIDANG (
    ID_LuuCongViec VARCHAR(50) PRIMARY KEY,
    ID_UngVien VARCHAR(50) NOT NULL,
    ID_BaiDang VARCHAR(50) NOT NULL,
    NgayLuu DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_UngVien) REFERENCES UNGVIEN(ID_UngVien) ON DELETE CASCADE,
    FOREIGN KEY (ID_BaiDang) REFERENCES BAIDANG(ID_BaiDang) ON DELETE CASCADE,
    UNIQUE KEY unique_save (ID_UngVien, ID_BaiDang),
    INDEX idx_ungvien (ID_UngVien),
    INDEX idx_baidang (ID_BaiDang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 9. BẢNG ĐƠN ỨNG TUYỂN
-- =============================================
CREATE TABLE DONUNGTUYEN (
    ID_DonUngTuyen VARCHAR(50) PRIMARY KEY,
    ID_BaiDang VARCHAR(50) NOT NULL,
    ID_UngVien VARCHAR(50) NOT NULL,
    FileCV VARCHAR(255),
    ThuXinViec TEXT,
    TrangThai ENUM('Mới nộp', 'Đã xem', 'Mời phỏng vấn', 'Từ chối', 'Trúng tuyển') DEFAULT 'Mới nộp',
    NgayUngTuyen DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_BaiDang) REFERENCES BAIDANG(ID_BaiDang) ON DELETE CASCADE,
    FOREIGN KEY (ID_UngVien) REFERENCES UNGVIEN(ID_UngVien) ON DELETE CASCADE,
    UNIQUE KEY unique_application (ID_BaiDang, ID_UngVien),
    INDEX idx_baidang (ID_BaiDang),
    INDEX idx_ungvien (ID_UngVien),
    INDEX idx_trangthai (TrangThai),
    INDEX idx_ngayungtuyen (NgayUngTuyen)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 10. BẢNG THÔNG BÁO
-- =============================================
CREATE TABLE THONGBAOUNGTUYEN (
    ID_ThongBao VARCHAR(50) PRIMARY KEY,
    ID_UngVien VARCHAR(50) NOT NULL,
    ID_DonUngTuyen VARCHAR(50),
    TieuDe VARCHAR(255) NOT NULL,
    NoiDung TEXT,
    LoaiThongBao ENUM('Hệ thống', 'Ứng tuyển', 'Phỏng vấn', 'Kết quả') DEFAULT 'Hệ thống',
    DaDoc BOOLEAN DEFAULT FALSE,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_UngVien) REFERENCES UNGVIEN(ID_UngVien) ON DELETE CASCADE,
    FOREIGN KEY (ID_DonUngTuyen) REFERENCES DONUNGTUYEN(ID_DonUngTuyen) ON DELETE SET NULL,
    INDEX idx_ungvien (ID_UngVien),
    INDEX idx_dadoc (DaDoc),
    INDEX idx_ngaytao (NgayTao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 11. BẢNG ĐÁNH GIÁ NHÀ TUYỂN DỤNG
-- =============================================
CREATE TABLE DANHGIA (
    ID_DanhGia VARCHAR(50) PRIMARY KEY,
    ID_NhaTuyenDung VARCHAR(50) NOT NULL,
    ID_UngVien VARCHAR(50) NOT NULL,
    DiemDanhGia INT CHECK (DiemDanhGia BETWEEN 1 AND 5),
    NhanXet LONGTEXT,
    NgayDanhGia DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_NhaTuyenDung) REFERENCES NHATUYENDUNG(ID_NhaTuyenDung) ON DELETE CASCADE,
    FOREIGN KEY (ID_UngVien) REFERENCES UNGVIEN(ID_UngVien) ON DELETE CASCADE,
    UNIQUE KEY unique_review (ID_NhaTuyenDung, ID_UngVien),
    INDEX idx_nhatuyendung (ID_NhaTuyenDung),
    INDEX idx_ungvien (ID_UngVien)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 12. BẢNG QUẢN LÝ BÀI ĐĂNG (Admin Log)
-- =============================================
CREATE TABLE QUANLYBAIDANG (
    ID_QuanLy VARCHAR(50) PRIMARY KEY,
    ID_BaiDang VARCHAR(50) NOT NULL,
    ID_NhaTuyenDung VARCHAR(50) NOT NULL,
    ID_Admin VARCHAR(50),
    HanhDong VARCHAR(100) NOT NULL,
    LyDo TEXT,
    ThoiGian DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_BaiDang) REFERENCES BAIDANG(ID_BaiDang) ON DELETE CASCADE,
    FOREIGN KEY (ID_NhaTuyenDung) REFERENCES NHATUYENDUNG(ID_NhaTuyenDung) ON DELETE CASCADE,
    FOREIGN KEY (ID_Admin) REFERENCES TAIKHOAN(ID_TaiKhoan) ON DELETE SET NULL,
    INDEX idx_baidang (ID_BaiDang),
    INDEX idx_nhatuyendung (ID_NhaTuyenDung),
    INDEX idx_thoigian (ThoiGian)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 13. BẢNG QUẢN LÝ TÀI KHOẢN CÁ NHÂN
-- =============================================
CREATE TABLE QUANLYTAIKHOANCANHAN (
    ID_QuanLyTaiKhoan VARCHAR(50) PRIMARY KEY,
    ID_TaiKhoan VARCHAR(50) NOT NULL,
    LoaiNguoiDung ENUM('Ứng viên', 'Nhà tuyển dụng', 'Admin') NOT NULL,
    ThongTinTaiKhoan LONGTEXT,
    HanhDong VARCHAR(100),
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP,
    NguoiCapNhat VARCHAR(50),
    FOREIGN KEY (ID_TaiKhoan) REFERENCES TAIKHOAN(ID_TaiKhoan) ON DELETE CASCADE,
    INDEX idx_taikhoan (ID_TaiKhoan),
    INDEX idx_ngaycapnhat (NgayCapNhat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
