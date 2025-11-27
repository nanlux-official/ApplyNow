# 📋 TỔNG QUAN HỆ THỐNG TUYỂN DỤNG

## 🎯 Giới thiệu

Hệ thống tuyển dụng trực tuyến được xây dựng bằng PHP thuần (không framework), MySQL, và kiến trúc MVC. Hệ thống hỗ trợ 3 vai trò chính: Admin, Nhà tuyển dụng, và Ứng viên.

---

## 🏗️ KIẾN TRÚC HỆ THỐNG

### Mô hình MVC (Model-View-Controller)

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────────┐
│  Router (core/Router.php)           │
│  - Phân tích URL                    │
│  - Gọi Controller tương ứng         │
└──────┬──────────────────────────────┘
       │
       ▼
┌─────────────────────────────────────┐
│  Controller (controllers/)          │
│  - Xử lý logic nghiệp vụ            │
│  - Gọi Model để lấy/lưu dữ liệu     │
└──────┬──────────────────────────────┘
       │
       ▼
┌─────────────────────────────────────┐
│  Model (models/)                    │
│  - Tương tác với Database           │
│  - Xử lý dữ liệu                    │
└──────┬──────────────────────────────┘
       │
       ▼
┌─────────────────────────────────────┐
│  View (views/)                      │
│  - Hiển thị giao diện               │
│  - Render HTML                      │
└─────────────────────────────────────┘
```


---

## 📁 CẤU TRÚC THỦ MỤC

```
job-recruitment/
│
├── config/                      # Cấu hình hệ thống
│   ├── config.php              # Cấu hình chung (URL, email, upload)
│   └── database.php            # Cấu hình database
│
├── core/                        # Core classes
│   ├── Database.php            # Kết nối và query database
│   ├── Controller.php          # Base controller
│   ├── Router.php              # URL routing
│   └── Middleware.php          # Authentication & Authorization
│
├── controllers/                 # Controllers
│   ├── AuthController.php      # Đăng ký, đăng nhập, quên mật khẩu
│   ├── JobController.php       # Tìm kiếm, xem chi tiết việc làm
│   ├── AdminController.php     # Quản lý hệ thống
│   ├── EmployerController.php  # Quản lý tin tuyển dụng
│   ├── ApplicantController.php # Quản lý hồ sơ ứng tuyển
│   └── SupportController.php   # Hỗ trợ khách hàng
│
├── models/                      # Models
│   ├── User.php                # Người dùng
│   ├── Applicant.php           # Ứng viên
│   ├── Employer.php            # Nhà tuyển dụng
│   ├── Job.php                 # Công việc
│   ├── Application.php         # Đơn ứng tuyển
│   ├── Notification.php        # Thông báo
│   ├── SavedJob.php            # Việc làm đã lưu
│   ├── Review.php              # Đánh giá
│   ├── AdminLog.php            # Log hoạt động admin
│   └── SupportTicket.php       # Ticket hỗ trợ
│
├── views/                       # Views (Giao diện)
│   ├── layouts/                # Layout chung
│   │   ├── header.php          # Header (menu, navigation)
│   │   └── footer.php          # Footer
│   │
│   ├── auth/                   # Xác thực
│   │   ├── register.php        # Đăng ký
│   │   ├── login.php           # Đăng nhập
│   │   ├── forgot-password.php # Quên mật khẩu
│   │   └── reset-password.php  # Đặt lại mật khẩu
│   │
│   ├── jobs/                   # Việc làm
│   │   ├── search.php          # Trang chủ - Tìm kiếm
│   │   ├── detail.php          # Chi tiết công việc
│   │   └── apply.php           # Form ứng tuyển
│   │
│   ├── applicant/              # Dashboard ứng viên
│   │   ├── dashboard.php       # Tổng quan
│   │   ├── profile.php         # Hồ sơ cá nhân
│   │   ├── applications.php    # Đơn ứng tuyển
│   │   ├── application-detail.php
│   │   ├── saved-jobs.php      # Việc làm đã lưu
│   │   └── notifications.php   # Thông báo
│   │
│   ├── employer/               # Dashboard nhà tuyển dụng
│   │   ├── dashboard.php       # Tổng quan
│   │   ├── profile.php         # Thông tin công ty
│   │   ├── post-job.php        # Đăng tin tuyển dụng
│   │   ├── manage-jobs.php     # Quản lý tin đăng
│   │   ├── edit-job.php        # Sửa tin đăng
│   │   ├── manage-applications.php  # Quản lý ứng viên
│   │   └── application-detail.php
│   │
│   ├── admin/                  # Dashboard admin
│   │   ├── dashboard.php       # Tổng quan hệ thống
│   │   ├── users.php           # Quản lý người dùng
│   │   ├── user-detail.php     # Chi tiết người dùng
│   │   ├── user-edit.php       # Sửa người dùng
│   │   ├── jobs.php            # Quản lý việc làm
│   │   ├── job-edit.php        # Sửa việc làm
│   │   └── support-tickets.php # Quản lý ticket hỗ trợ
│   │
│   └── support/                # Hỗ trợ
│       ├── my-tickets.php      # Danh sách ticket
│       ├── create.php          # Tạo ticket mới
│       ├── detail.php          # Chi tiết ticket
│       └── upgrade-employer.php # Yêu cầu nâng cấp
│
├── utils/                       # Utilities
│   ├── helpers.php             # Hàm tiện ích
│   ├── validation.php          # Validate dữ liệu
│   └── email.php               # Gửi email
│
├── public/                      # Public files (Document Root)
│   ├── index.php               # Entry point
│   ├── .htaccess               # URL rewrite
│   ├── css/
│   │   └── style.css           # CSS chính
│   ├── js/
│   │   └── main.js             # JavaScript chính
│   └── uploads/                # File upload
│       ├── cv/                 # CV ứng viên
│       ├── logo/               # Logo công ty
│       └── avatar/             # Avatar người dùng
│
└── database/                    # Database
    ├── schema.sql              # Cấu trúc database
    └── seed.sql                # Dữ liệu mẫu
```

---

## 👥 VAI TRÒ NGƯỜI DÙNG

### 1. 🔴 ADMIN (Quản trị viên)

**Quyền hạn:**
- Quản lý toàn bộ hệ thống
- Quản lý người dùng (xem, sửa, xóa, khóa tài khoản)
- Quản lý việc làm (duyệt, sửa, xóa tin đăng)
- Thay đổi vai trò người dùng
- Xem thống kê hệ thống
- Xử lý ticket hỗ trợ
- Xem log hoạt động

**Tài khoản mặc định:**
- Email: admin@jobsite.com
- Password: 123456

---

### 2. 🟢 NHÀ TUYỂN DỤNG (Employer)

**Quyền hạn:**
- Đăng tin tuyển dụng
- Quản lý tin đăng (sửa, xóa, đóng/mở tin)
- Xem danh sách ứng viên
- Duyệt/từ chối đơn ứng tuyển
- Xem hồ sơ ứng viên
- Tải CV ứng viên
- Quản lý thông tin công ty
- Upload logo công ty
- Xem thống kê tin đăng

**Tài khoản mặc định:**
- Email: hr@fpt.com.vn
- Password: 123456

---

### 3. 🔵 ỨNG VIÊN (Applicant)

**Quyền hạn:**
- Tìm kiếm việc làm
- Xem chi tiết công việc
- Ứng tuyển công việc
- Upload CV
- Lưu việc làm yêu thích
- Xem trạng thái đơn ứng tuyển
- Quản lý hồ sơ cá nhân
- Đánh giá nhà tuyển dụng
- Nhận thông báo

**Tài khoản mặc định:**
- Email: nguyenvana@gmail.com
- Password: 123456

---

## ⚙️ CHỨC NĂNG CHI TIẾT

### 🔐 Module Xác thực (Authentication)

#### 1. Đăng ký tài khoản
- Chọn vai trò (Ứng viên/Nhà tuyển dụng)
- Validate email, mật khẩu
- Mã hóa mật khẩu (password_hash)
- Gửi email xác thực
- Tự động đăng nhập sau khi đăng ký

#### 2. Đăng nhập
- Xác thực email/password
- Tạo session
- Redirect theo vai trò
- Remember me (tùy chọn)

#### 3. Quên mật khẩu
- Nhập email
- Gửi link reset password
- Token có thời hạn (1 giờ)
- Đặt lại mật khẩu mới

#### 4. Đăng xuất
- Xóa session
- Redirect về trang chủ

---

### 🏠 Module Trang chủ & Tìm kiếm

#### 1. Trang chủ
- Hiển thị thống kê (số việc làm, công ty, ứng viên)
- Form tìm kiếm nổi bật
- Danh mục ngành nghề phổ biến (8 ngành)
- Cách thức hoạt động (3 bước)
- Danh sách việc làm mới nhất

#### 2. Tìm kiếm việc làm
**Bộ lọc:**
- Từ khóa (tên công việc, mô tả)
- Địa điểm
- Loại công việc (Full-time, Part-time, Thực tập, Freelance)
- Kinh nghiệm (Chưa có, 1-2 năm, 2-3 năm, 3-5 năm, 5+ năm)
- Lĩnh vực

**Sắp xếp:**
- Mới nhất
- Lương cao nhất
- Xem nhiều nhất

**Hiển thị:**
- Grid layout (3 cột)
- Thông tin: Logo, tên công ty, vị trí, lương, địa điểm
- Phân trang

#### 3. Chi tiết công việc
- Thông tin đầy đủ về công việc
- Thông tin công ty
- Nút ứng tuyển/lưu việc làm
- Đánh giá công ty
- Việc làm liên quan

---

### 💼 Module Ứng viên (Applicant)

#### 1. Dashboard
- Thống kê tổng quan:
  - Số đơn ứng tuyển
  - Đơn đang chờ
  - Đơn được chấp nhận
  - Việc làm đã lưu
- Đơn ứng tuyển gần đây
- Thông báo mới

#### 2. Quản lý hồ sơ
- Thông tin cá nhân (họ tên, email, SĐT, địa chỉ)
- Học vấn
- Kinh nghiệm làm việc
- Kỹ năng
- Upload avatar
- Đổi mật khẩu

#### 3. Ứng tuyển công việc
- Upload CV (PDF, DOC, DOCX)
- Viết thư xin việc
- Kiểm tra đã ứng tuyển chưa
- Gửi thông báo cho nhà tuyển dụng

#### 4. Quản lý đơn ứng tuyển
- Danh sách tất cả đơn
- Trạng thái: Đang chờ, Đã xem, Chấp nhận, Từ chối
- Xem chi tiết đơn
- Xóa đơn
- Lọc theo trạng thái

#### 5. Việc làm đã lưu
- Danh sách việc làm yêu thích
- Bỏ lưu việc làm
- Ứng tuyển nhanh

#### 6. Thông báo
- Thông báo đơn ứng tuyển được xem
- Thông báo đơn được chấp nhận/từ chối
- Đánh dấu đã đọc

#### 7. Đánh giá nhà tuyển dụng
- Đánh giá sau khi ứng tuyển
- Rating 1-5 sao
- Viết nhận xét

---

### 🏢 Module Nhà tuyển dụng (Employer)

#### 1. Dashboard
- Thống kê:
  - Tổng số tin đăng
  - Tin đang hoạt động
  - Tổng ứng viên
  - Ứng viên mới
- Tin đăng gần đây
- Ứng viên mới nhất

#### 2. Quản lý thông tin công ty
- Tên công ty
- Mô tả công ty
- Website
- Địa chỉ
- Số điện thoại
- Upload logo
- Đổi mật khẩu

#### 3. Đăng tin tuyển dụng
**Thông tin công việc:**
- Tiêu đề
- Mô tả công việc
- Yêu cầu
- Quyền lợi
- Mức lương
- Địa điểm
- Loại công việc
- Kinh nghiệm yêu cầu
- Lĩnh vực
- Hạn nộp hồ sơ

#### 4. Quản lý tin đăng
- Danh sách tất cả tin
- Sửa tin đăng
- Xóa tin đăng
- Đóng/Mở tin tuyển dụng
- Xem số lượt xem
- Xem số ứng viên

#### 5. Quản lý ứng viên
- Danh sách tất cả đơn ứng tuyển
- Lọc theo:
  - Tin đăng
  - Trạng thái
  - Ngày ứng tuyển
- Xem chi tiết hồ sơ
- Tải CV
- Duyệt/Từ chối đơn
- Xóa đơn

#### 6. Chi tiết ứng viên
- Thông tin cá nhân
- Học vấn
- Kinh nghiệm
- Kỹ năng
- Thư xin việc
- Download CV
- Cập nhật trạng thái

---

### 👨‍💼 Module Admin

#### 1. Dashboard
- Thống kê tổng quan:
  - Tổng người dùng
  - Tổng việc làm
  - Tổng đơn ứng tuyển
  - Người dùng mới (7 ngày)
- Biểu đồ thống kê
- Hoạt động gần đây

#### 2. Quản lý người dùng
- Danh sách tất cả người dùng
- Lọc theo vai trò
- Tìm kiếm
- Xem chi tiết
- Sửa thông tin
- Khóa/Mở khóa tài khoản
- Thay đổi vai trò
- Xóa người dùng
- Xem log hoạt động

#### 3. Quản lý việc làm
- Danh sách tất cả tin đăng
- Lọc theo trạng thái
- Tìm kiếm
- Xem chi tiết
- Sửa tin đăng
- Duyệt/Từ chối tin
- Xóa tin đăng
- Xem thống kê

#### 4. Quản lý ticket hỗ trợ
- Danh sách ticket
- Lọc theo trạng thái
- Xem chi tiết
- Trả lời ticket
- Cập nhật trạng thái
- Đóng ticket

#### 5. Log hoạt động
- Ghi lại mọi thao tác của admin
- Thời gian, hành động, đối tượng
- Tìm kiếm log

---

### 🎫 Module Hỗ trợ (Support)

#### 1. Tạo ticket hỗ trợ
- Chọn loại vấn đề:
  - Vấn đề kỹ thuật
  - Vấn đề tài khoản
  - Yêu cầu nâng cấp
  - Khác
- Tiêu đề
- Mô tả chi tiết
- Độ ưu tiên

#### 2. Quản lý ticket
- Danh sách ticket của tôi
- Trạng thái: Mới, Đang xử lý, Đã giải quyết, Đóng
- Xem chi tiết
- Trả lời/Bình luận
- Đóng ticket

#### 3. Yêu cầu nâng cấp tài khoản
- Ứng viên → Nhà tuyển dụng
- Điền thông tin công ty
- Admin duyệt yêu cầu

---

## 🗄️ CẤU TRÚC DATABASE

### Bảng chính

#### 1. NguoiDung (Users)
```sql
- ID_NguoiDung (PK)
- Email (unique)
- MatKhau (hashed)
- VaiTro (ADMIN, EMPLOYER, APPLICANT)
- TrangThai (active, inactive, banned)
- NgayTao
- LanDangNhapCuoi
```

#### 2. UngVien (Applicants)
```sql
- ID_UngVien (PK)
- ID_NguoiDung (FK)
- HoTen
- SoDienThoai
- DiaChi
- HocVan
- KinhNghiem
- KyNang
- Avatar
```

#### 3. NhaTuyenDung (Employers)
```sql
- ID_NhaTuyenDung (PK)
- ID_NguoiDung (FK)
- TenCongTy
- MoTa
- Website
- DiaChi
- SoDienThoai
- Logo
```

#### 4. BaiDang (Jobs)
```sql
- ID_BaiDang (PK)
- ID_NhaTuyenDung (FK)
- TieuDe
- MoTa
- YeuCau
- QuyenLoi
- MucLuong
- DiaDiem
- LoaiCongViec
- KinhNghiem
- LinhVuc
- HanNopHoSo
- TrangThai (active, closed, pending)
- LuotXem
- NgayDangTin
```

#### 5. DonUngTuyen (Applications)
```sql
- ID_DonUngTuyen (PK)
- ID_BaiDang (FK)
- ID_UngVien (FK)
- FileCV
- ThuXinViec
- TrangThai (pending, viewed, accepted, rejected)
- NgayUngTuyen
- NgayCapNhat
```

#### 6. ThongBao (Notifications)
```sql
- ID_ThongBao (PK)
- ID_NguoiDung (FK)
- LoaiThongBao
- NoiDung
- DaDoc
- NgayTao
```

#### 7. ViecLamDaLuu (SavedJobs)
```sql
- ID (PK)
- ID_UngVien (FK)
- ID_BaiDang (FK)
- NgayLuu
```

#### 8. DanhGia (Reviews)
```sql
- ID_DanhGia (PK)
- ID_NhaTuyenDung (FK)
- ID_UngVien (FK)
- DiemDanhGia (1-5)
- NhanXet
- NgayDanhGia
```

#### 9. TicketHoTro (SupportTickets)
```sql
- ID_Ticket (PK)
- ID_NguoiDung (FK)
- LoaiVanDe
- TieuDe
- MoTa
- DoUuTien
- TrangThai (new, processing, resolved, closed)
- NgayTao
- NgayCapNhat
```

#### 10. LogHoatDong (AdminLogs)
```sql
- ID_Log (PK)
- ID_Admin (FK)
- HanhDong
- DoiTuong
- ChiTiet
- ThoiGian
```

---

## 🔄 LUỒNG HOẠT ĐỘNG

### Luồng ứng tuyển việc làm

```
1. Ứng viên đăng ký/đăng nhập
   ↓
2. Tìm kiếm việc làm phù hợp
   ↓
3. Xem chi tiết công việc
   ↓
4. Click "Ứng tuyển"
   ↓
5. Upload CV + Viết thư xin việc
   ↓
6. Hệ thống lưu đơn ứng tuyển
   ↓
7. Gửi thông báo cho nhà tuyển dụng
   ↓
8. Nhà tuyển dụng xem đơn
   ↓
9. Gửi thông báo "Đã xem" cho ứng viên
   ↓
10. Nhà tuyển dụng duyệt/từ chối
    ↓
11. Gửi thông báo kết quả cho ứng viên
    ↓
12. Ứng viên có thể đánh giá công ty
```

### Luồng đăng tin tuyển dụng

```
1. Nhà tuyển dụng đăng ký/đăng nhập
   ↓
2. Vào "Đăng tin tuyển dụng"
   ↓
3. Điền thông tin công việc
   ↓
4. Submit form
   ↓
5. Hệ thống validate dữ liệu
   ↓
6. Lưu vào database (trạng thái: active)
   ↓
7. Hiển thị trên trang tìm kiếm
   ↓
8. Ứng viên có thể xem và ứng tuyển
```

### Luồng xử lý ticket hỗ trợ

```
1. Người dùng tạo ticket
   ↓
2. Chọn loại vấn đề + Mô tả
   ↓
3. Hệ thống lưu ticket (trạng thái: new)
   ↓
4. Admin xem danh sách ticket
   ↓
5. Admin mở ticket và trả lời
   ↓
6. Cập nhật trạng thái: processing
   ↓
7. Người dùng nhận thông báo
   ↓
8. Người dùng có thể trả lời lại
   ↓
9. Admin giải quyết xong
   ↓
10. Cập nhật trạng thái: resolved
    ↓
11. Đóng ticket
```

---

## 🔒 BẢO MẬT

### 1. Xác thực & Phân quyền
- Session-based authentication
- Middleware kiểm tra quyền truy cập
- Role-based access control (RBAC)
- Tự động redirect nếu không có quyền

### 2. Bảo vệ dữ liệu
- Mã hóa mật khẩu (password_hash với BCRYPT)
- Prepared statements (PDO) chống SQL Injection
- Escape output (htmlspecialchars) chống XSS
- CSRF token cho form quan trọng
- Validate input trước khi xử lý

### 3. Upload file
- Kiểm tra loại file (whitelist)
- Giới hạn kích thước file
- Đổi tên file ngẫu nhiên
- Lưu ngoài document root
- Kiểm tra MIME type

### 4. Session
- Session timeout
- Regenerate session ID sau login
- Secure session cookie
- HttpOnly flag

---

## 🎨 GIAO DIỆN

### Thiết kế
- **Responsive Design**: Tương thích mobile, tablet, desktop
- **Modern UI**: Gradient, shadow, animation
- **Color Scheme**: 
  - Primary: #3B82F6 (Blue)
  - Success: #10B981 (Green)
  - Warning: #F59E0B (Orange)
  - Danger: #EF4444 (Red)
- **Typography**: System fonts, clean và dễ đọc
- **Icons**: Emoji icons cho UI thân thiện

### Components
- Cards với hover effect
- Modal dialogs
- Toast notifications
- Loading states
- Empty states
- Pagination
- Breadcrumbs
- Tabs
- Badges
- Tooltips

---

## 📧 HỆ THỐNG EMAIL

### Các email tự động

1. **Email xác thực tài khoản**
   - Gửi sau khi đăng ký
   - Link xác thực có thời hạn

2. **Email quên mật khẩu**
   - Link reset password
   - Token có thời hạn 1 giờ

3. **Email thông báo đơn ứng tuyển**
   - Gửi cho nhà tuyển dụng khi có đơn mới
   - Thông tin ứng viên và công việc

4. **Email thông báo trạng thái đơn**
   - Gửi cho ứng viên khi đơn được xem/duyệt/từ chối

5. **Email thông báo ticket**
   - Gửi khi có phản hồi từ admin

### Cấu hình SMTP
```php
SMTP_HOST: smtp.gmail.com
SMTP_PORT: 587
SMTP_ENCRYPTION: TLS
```

---

## 🔍 TÌM KIẾM & LỌC

### Tìm kiếm việc làm
- **Full-text search**: Tìm trong tiêu đề, mô tả, yêu cầu
- **Filters**:
  - Địa điểm
  - Loại công việc
  - Kinh nghiệm
  - Lĩnh vực
  - Mức lương
- **Sort**:
  - Mới nhất
  - Lương cao nhất
  - Xem nhiều nhất
- **Pagination**: 12 items/page

### Tìm kiếm người dùng (Admin)
- Tìm theo email, tên
- Lọc theo vai trò
- Lọc theo trạng thái

### Tìm kiếm đơn ứng tuyển
- Lọc theo công việc
- Lọc theo trạng thái
- Sắp xếp theo ngày

---

## 📊 THỐNG KÊ & BÁO CÁO

### Dashboard Admin
- Tổng số người dùng (theo vai trò)
- Tổng số việc làm (active/closed)
- Tổng số đơn ứng tuyển
- Người dùng mới (7 ngày, 30 ngày)
- Biểu đồ tăng trưởng

### Dashboard Employer
- Tổng tin đăng
- Tin đang hoạt động
- Tổng ứng viên
- Ứng viên mới
- Lượt xem tin đăng
- Tỷ lệ chuyển đổi

### Dashboard Applicant
- Tổng đơn ứng tuyển
- Đơn đang chờ
- Đơn được chấp nhận
- Đơn bị từ chối
- Việc làm đã lưu

---

## 🚀 TÍNH NĂNG NỔI BẬT

### 1. Tìm kiếm thông minh
- Tìm kiếm full-text
- Bộ lọc đa dạng
- Gợi ý tìm kiếm
- Lưu lịch sử tìm kiếm

### 2. Thông báo real-time
- Thông báo trong hệ thống
- Badge hiển thị số thông báo mới
- Đánh dấu đã đọc
- Email notification

### 3. Lưu việc làm yêu thích
- Lưu để xem sau
- Quản lý danh sách yêu thích
- Ứng tuyển nhanh

### 4. Đánh giá & Review
- Đánh giá nhà tuyển dụng
- Rating 1-5 sao
- Viết nhận xét
- Hiển thị điểm trung bình

### 5. Upload file
- Upload CV (PDF, DOC, DOCX)
- Upload logo công ty
- Upload avatar
- Preview file
- Download file

### 6. Hệ thống hỗ trợ
- Ticket system
- Phân loại vấn đề
- Độ ưu tiên
- Trạng thái xử lý
- Lịch sử trao đổi

### 7. Quản lý phân quyền
- 3 vai trò rõ ràng
- Middleware kiểm tra quyền
- Admin có thể thay đổi vai trò
- Nâng cấp tài khoản

### 8. Log hoạt động
- Ghi lại mọi thao tác admin
- Audit trail
- Tìm kiếm log
- Export log

---

## 🛠️ CÔNG NGHỆ SỬ DỤNG

### Backend
- **PHP 7.4+**: Ngôn ngữ chính
- **MySQL 5.7+**: Database
- **PDO**: Database abstraction
- **Session**: Authentication

### Frontend
- **HTML5**: Markup
- **CSS3**: Styling (Flexbox, Grid, Animation)
- **JavaScript (Vanilla)**: Interactivity
- **AJAX**: Async requests

### Server
- **Apache**: Web server
- **mod_rewrite**: URL rewriting
- **.htaccess**: Configuration

### Tools
- **XAMPP**: Development environment
- **Git**: Version control
- **phpMyAdmin**: Database management

---

## 📱 RESPONSIVE DESIGN

### Breakpoints
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

### Mobile Features
- Hamburger menu
- Touch-friendly buttons
- Swipe gestures
- Optimized images
- Fast loading

---

## ⚡ HIỆU SUẤT

### Optimization
- **Database**: Indexes trên các cột thường query
- **Queries**: Prepared statements, avoid N+1
- **Caching**: Session caching
- **Images**: Optimized size
- **CSS/JS**: Minified (production)
- **Pagination**: Limit results per page

### Loading Time
- Trang chủ: < 2s
- Tìm kiếm: < 1s
- Dashboard: < 1.5s

---

## 🔄 API ENDPOINTS

### Public Routes
```
GET  /                          # Trang chủ
GET  /jobs                      # Danh sách việc làm
GET  /jobs/:id                  # Chi tiết việc làm
GET  /register                  # Form đăng ký
POST /register                  # Xử lý đăng ký
GET  /login                     # Form đăng nhập
POST /login                     # Xử lý đăng nhập
GET  /logout                    # Đăng xuất
```

### Applicant Routes (Protected)
```
GET  /applicant/dashboard       # Dashboard
GET  /applicant/profile         # Hồ sơ
POST /applicant/profile         # Cập nhật hồ sơ
GET  /applicant/applications    # Đơn ứng tuyển
GET  /applicant/saved-jobs      # Việc làm đã lưu
POST /jobs/:id/apply            # Ứng tuyển
POST /jobs/:id/save             # Lưu việc làm
```

### Employer Routes (Protected)
```
GET  /employer/dashboard        # Dashboard
GET  /employer/jobs             # Quản lý tin đăng
GET  /employer/jobs/create      # Form đăng tin
POST /employer/jobs/create      # Xử lý đăng tin
GET  /employer/jobs/:id/edit    # Form sửa tin
POST /employer/jobs/:id/update  # Xử lý sửa tin
GET  /employer/applications     # Quản lý ứng viên
POST /employer/applications/:id/status  # Cập nhật trạng thái
```

### Admin Routes (Protected)
```
GET  /admin/dashboard           # Dashboard
GET  /admin/users               # Quản lý người dùng
GET  /admin/users/:id           # Chi tiết người dùng
POST /admin/users/:id/update    # Cập nhật người dùng
GET  /admin/jobs                # Quản lý việc làm
POST /admin/jobs/:id/status     # Cập nhật trạng thái
```

---

## 📝 CODING STANDARDS

### PHP
- PSR-12 coding style
- Camel case cho methods
- Pascal case cho classes
- Snake case cho database columns
- Comments cho functions phức tạp

### SQL
- Uppercase cho keywords
- Lowercase cho table/column names
- Indexes cho foreign keys
- Constraints cho data integrity

### JavaScript
- Camel case cho variables
- Const/let thay vì var
- Arrow functions
- Async/await cho promises

---

## 🎯 ROADMAP (Tính năng tương lai)

### Phase 2
- [ ] Chat real-time giữa ứng viên và nhà tuyển dụng
- [ ] Video interview
- [ ] AI matching ứng viên - công việc
- [ ] Mobile app (React Native)
- [ ] Payment gateway (gói premium)

### Phase 3
- [ ] Multi-language support
- [ ] Advanced analytics
- [ ] API for third-party integration
- [ ] Blockchain verification
- [ ] AI resume parser

---

## 📞 HỖ TRỢ & BẢO TRÌ

### Backup
- Database backup hàng ngày
- File backup hàng tuần
- Lưu trữ backup 30 ngày

### Monitoring
- Error logging
- Performance monitoring
- Uptime monitoring
- Security scanning

### Updates
- Security patches
- Bug fixes
- Feature updates
- Database migrations

---

## ✅ CHECKLIST TRIỂN KHAI

- [x] Cấu trúc database hoàn chỉnh
- [x] Authentication & Authorization
- [x] Module Admin đầy đủ
- [x] Module Employer đầy đủ
- [x] Module Applicant đầy đủ
- [x] Tìm kiếm & Lọc
- [x] Upload file
- [x] Email notifications
- [x] Responsive design
- [x] Security measures
- [x] Support system
- [x] Documentation đầy đủ
- [x] Setup scripts tự động

---

**Phiên bản:** 1.0.0  
**Ngày cập nhật:** 28/11/2024  
**Tác giả:** Job Recruitment Team

---

*Để biết thêm chi tiết, xem các file:*
- `INSTALLATION.md` - Hướng dẫn cài đặt
- `USER_GUIDE.md` - Hướng dẫn sử dụng
- `ARCHITECTURE.md` - Kiến trúc chi tiết
- `API_ROUTES.md` - API documentation
