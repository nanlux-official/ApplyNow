-- =============================================
-- BẢNG HỖ TRỢ (SUPPORT TICKETS)
-- =============================================

DROP TABLE IF EXISTS TICKET_REPLIES;
DROP TABLE IF EXISTS SUPPORT_TICKETS;

CREATE TABLE SUPPORT_TICKETS (
    ID_Ticket VARCHAR(50) PRIMARY KEY,
    ID_NguoiDung VARCHAR(50) NOT NULL,
    LoaiNguoiDung ENUM('APPLICANT', 'EMPLOYER') NOT NULL,
    TieuDe VARCHAR(255) NOT NULL,
    NoiDung TEXT NOT NULL,
    TrangThai VARCHAR(50) DEFAULT 'Mới',
    DoUuTien VARCHAR(50) DEFAULT 'Trung bình',
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    NguoiXuLy VARCHAR(50),
    GhiChu TEXT,
    INDEX idx_nguoidung (ID_NguoiDung),
    INDEX idx_trangthai (TrangThai),
    INDEX idx_ngaytao (NgayTao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng phản hồi ticket
CREATE TABLE TICKET_REPLIES (
    ID_Reply VARCHAR(50) PRIMARY KEY,
    ID_Ticket VARCHAR(50) NOT NULL,
    ID_NguoiGui VARCHAR(50) NOT NULL,
    LoaiNguoiGui VARCHAR(20) NOT NULL,
    NoiDung TEXT NOT NULL,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Ticket) REFERENCES SUPPORT_TICKETS(ID_Ticket) ON DELETE CASCADE,
    INDEX idx_ticket (ID_Ticket),
    INDEX idx_ngaytao (NgayTao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
