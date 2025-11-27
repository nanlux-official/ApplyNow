# 🚀 ApplyNow - Hệ thống Tuyển dụng Trực tuyến

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Hệ thống tuyển dụng trực tuyến được xây dựng bằng PHP thuần, MySQL, và kiến trúc MVC. Hỗ trợ 3 vai trò: Admin, Nhà tuyển dụng, và Ứng viên.

---

## ✨ Tính năng nổi bật

- 🔍 **Tìm kiếm thông minh** - Full-text search với bộ lọc đa dạng
- 🔔 **Thông báo real-time** - Cập nhật trạng thái tức thì
- ❤️ **Lưu việc làm yêu thích** - Quản lý việc làm quan tâm
- ⭐ **Đánh giá & Review** - Đánh giá nhà tuyển dụng
- 📤 **Upload file** - CV, logo, avatar
- 🎫 **Hệ thống hỗ trợ** - Ticket system hoàn chỉnh
- 🔐 **Quản lý phân quyền** - 3 vai trò rõ ràng
- 📊 **Thống kê chi tiết** - Dashboard cho từng vai trò

---

## 📋 Yêu cầu hệ thống

- **XAMPP** (Apache + MySQL + PHP 7.4+)
- **Windows/Linux/Mac**
- **Git** (tùy chọn)

---

## 🚀 Cài đặt nhanh (3 bước)

### Bước 1: Clone hoặc Download

**Option 1: Dùng Git**
```bash
git clone https://github.com/nanlux-official/ApplyNow.git
```

**Option 2: Download ZIP**
- Download từ GitHub
- Giải nén vào `C:\xampp\htdocs\ApplyNow\`

### Bước 2: Chạy Setup tự động

1. Mở thư mục `ApplyNow`
2. **Nhấn chuột phải** vào file `setup-xampp.bat`
3. Chọn **"Run as administrator"**
4. Làm theo hướng dẫn trên màn hình

### Bước 3: Truy cập Website

Mở trình duyệt và truy cập:
```
http://localhost/ApplyNow/public
```

---

## 🔐 Tài khoản mặc định

### 👨‍💼 Admin
```
Email: admin@jobsite.com
Password: admin123
```

### 🏢 Nhà tuyển dụng
```
Email: employer@company.com
Password: employer123
```

### 👤 Ứng viên
```
Email: applicant@email.com
Password: applicant123
```

⚠️ **Quan trọng:** Đổi mật khẩu ngay sau khi đăng nhập lần đầu!

---

## 📁 Cấu trúc dự án

```
ApplyNow/
├── config/              # Cấu hình hệ thống
├── controllers/         # Controllers (MVC)
├── core/               # Core classes
├── database/           # SQL files
├── models/             # Models (MVC)
├── public/             # Public files (Document Root)
│   ├── css/
│   ├── js/
│   ├── uploads/
│   └── index.php       # Entry point
├── utils/              # Utilities
├── views/              # Views (MVC)
└── setup-xampp.bat     # Setup tự động
```

---

## 👥 Vai trò & Quyền hạn

### 🔴 Admin
- ✅ Quản lý toàn bộ hệ thống
- ✅ Quản lý người dùng (xem, sửa, xóa, khóa)
- ✅ Quản lý việc làm (duyệt, sửa, xóa)
- ✅ Xử lý ticket hỗ trợ
- ✅ Xem log hoạt động
- ✅ Thống kê hệ thống

### 🟢 Nhà tuyển dụng
- ✅ Đăng tin tuyển dụng
- ✅ Quản lý tin đăng (sửa, xóa, đóng/mở)
- ✅ Xem danh sách ứng viên
- ✅ Duyệt/từ chối đơn ứng tuyển
- ✅ Download CV ứng viên
- ✅ Quản lý thông tin công ty
- ✅ Xem thống kê tin đăng

### 🔵 Ứng viên
- ✅ Tìm kiếm việc làm
- ✅ Ứng tuyển công việc
- ✅ Upload CV
- ✅ Lưu việc làm yêu thích
- ✅ Xem trạng thái đơn ứng tuyển
- ✅ Quản lý hồ sơ cá nhân
- ✅ Đánh giá nhà tuyển dụng
- ✅ Nhận thông báo

---

## 🎯 Tính năng chính

### 🔍 Tìm kiếm & Lọc
- Tìm kiếm theo từ khóa
- Lọc theo địa điểm, loại công việc, kinh nghiệm, lĩnh vực
- Sắp xếp theo mới nhất, lương cao, xem nhiều
- Phân trang

### 💼 Quản lý Công việc
- Đăng tin tuyển dụng với đầy đủ thông tin
- Quản lý trạng thái tin đăng
- Thống kê lượt xem, số ứng viên
- Đóng/Mở tin tuyển dụng

### 📝 Quản lý Ứng tuyển
- Upload CV (PDF, DOC, DOCX)
- Viết thư xin việc
- Theo dõi trạng thái đơn
- Nhận thông báo cập nhật

### 🔔 Hệ thống Thông báo
- Thông báo đơn ứng tuyển mới
- Thông báo trạng thái đơn
- Badge số thông báo chưa đọc
- Đánh dấu đã đọc

### 🎫 Hỗ trợ Khách hàng
- Tạo ticket hỗ trợ
- Phân loại vấn đề
- Độ ưu tiên
- Lịch sử trao đổi
- Yêu cầu nâng cấp tài khoản

---

## 🛠️ Công nghệ sử dụng

- **Backend:** PHP 7.4+ (Pure PHP, no framework)
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Server:** Apache with mod_rewrite
- **Architecture:** MVC Pattern

---

## 📚 Tài liệu

- [📋 SYSTEM_OVERVIEW.md](SYSTEM_OVERVIEW.md) - Tổng quan hệ thống
- [✅ FEATURES_LIST.md](FEATURES_LIST.md) - Danh sách tính năng
- [📖 USER_GUIDE.md](USER_GUIDE.md) - Hướng dẫn sử dụng
- [🏗️ ARCHITECTURE.md](ARCHITECTURE.md) - Kiến trúc chi tiết
- [🚀 QUICK_START.md](QUICK_START.md) - Cài đặt nhanh
- [📝 INSTALLATION.md](INSTALLATION.md) - Hướng dẫn cài đặt chi tiết

---

## 🔒 Bảo mật

- ✅ Mã hóa mật khẩu (BCRYPT)
- ✅ Prepared statements (SQL Injection prevention)
- ✅ XSS protection (htmlspecialchars)
- ✅ CSRF protection
- ✅ Session management
- ✅ Role-based access control
- ✅ File upload validation

---

## 📊 Thống kê dự án

- **Tổng số tính năng:** 150+
- **Controllers:** 6
- **Models:** 10
- **Views:** 40+
- **Database tables:** 10
- **Routes:** 60+
- **Lines of code:** 12,000+

---

## 🔧 Khắc phục sự cố

### Lỗi: "Database connection failed"
```
✓ Kiểm tra MySQL đang chạy trong XAMPP
✓ Kiểm tra thông tin trong config/database.php
✓ Đảm bảo database đã được tạo
```

### Lỗi: "404 Not Found"
```
✓ Kiểm tra file .htaccess trong public/
✓ Bật mod_rewrite trong Apache
✓ Kiểm tra đường dẫn URL
```

### Lỗi: "Permission denied" khi upload
```
✓ Cấp quyền ghi cho thư mục public/uploads/
✓ Windows: Properties → Security → Edit
```

---

## 🤝 Đóng góp

Contributions, issues và feature requests đều được chào đón!

1. Fork dự án
2. Tạo branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

---

## 📝 License

Dự án này được phân phối dưới giấy phép MIT. Xem file [LICENSE](LICENSE) để biết thêm chi tiết.

---

## 👨‍💻 Tác giả

**Nanlux Official**
- GitHub: [@nanlux-official](https://github.com/nanlux-official)
- Repository: [ApplyNow](https://github.com/nanlux-official/ApplyNow)

---

## 🙏 Lời cảm ơn

- Cảm ơn tất cả những người đã đóng góp cho dự án
- Icons by Emoji
- Inspiration from modern job platforms

---

## 📞 Liên hệ & Hỗ trợ

- 📧 Email: support@applynow.com
- 🌐 Website: https://applynow.com
- 📱 GitHub Issues: [Create an issue](https://github.com/nanlux-official/ApplyNow/issues)

---

## ⚠️ Lưu ý quan trọng

- ✅ Dự án được thiết kế để chạy trên **XAMPP local** với **MySQL**
- ⚠️ **KHÔNG khuyến nghị** deploy lên cloud hosting (Render, Heroku, etc.) do cần chuyển đổi sang PostgreSQL
- ✅ Nếu cần deploy online, khuyến nghị dùng **shared hosting PHP** (Hostinger, Namecheap) với MySQL native
- ✅ Hoặc dùng **ngrok** để chia sẻ local server ra internet

---

⭐ **Nếu dự án hữu ích, hãy cho một star!** ⭐

**Made with ❤️ by Nanlux Official**
