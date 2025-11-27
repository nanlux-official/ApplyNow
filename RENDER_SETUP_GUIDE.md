# 🚀 HƯỚNG DẪN CẤU HÌNH RENDER - BƯỚC CUỐI CÙNG

## ⚠️ Vấn đề hiện tại

Từ logs của bạn, tôi thấy Render đang build với Node.js thay vì PHP. Cần cấu hình lại!

---

## 🔧 BƯỚC 1: Hủy deploy hiện tại

1. Vào Render Dashboard: https://dashboard.render.com
2. Click vào service **ApplyNow**
3. Click **"Cancel deploy"** (nút đỏ)
4. Đợi deploy dừng lại

---

## 🗑️ BƯỚC 2: Xóa service cũ (Khuyến nghị)

1. Vào **Settings** (tab bên trái)
2. Kéo xuống dưới cùng
3. Click **"Delete Web Service"**
4. Xác nhận xóa

---

## 🆕 BƯỚC 3: Tạo service mới với cấu hình đúng

### 3.1. Push code mới lên GitHub

Trước tiên, push các file mới tôi vừa tạo:

```bash
git add .
git commit -m "Add Render deployment files (Dockerfile, composer.json, Procfile)"
git push
```

### 3.2. Tạo Web Service mới

1. Vào Dashboard → Click **"New +"** → **"Web Service"**
2. Connect repository: **nanlux-official/ApplyNow**
3. Click **"Connect"**

### 3.3. Cấu hình service

Điền thông tin như sau:

```
Name: applynow
Region: Singapore
Branch: main
Root Directory: (để trống)

Build Command: (để trống)
Start Command: (để trống - sẽ dùng Dockerfile)

Environment: Docker
```

**QUAN TRỌNG:** Chọn **Docker** thay vì PHP!

### 3.4. Chọn plan

```
Instance Type: Free
```

### 3.5. Advanced settings (Mở rộng)

Thêm Environment Variables:

```
PORT = 80
```

### 3.6. Create Web Service

Click **"Create Web Service"** và đợi build!

---

## 🗄️ BƯỚC 4: Tạo PostgreSQL Database

### 4.1. Tạo database

1. Vào Dashboard → Click **"New +"** → **"PostgreSQL"**
2. Điền thông tin:

```
Name: applynow-db
Database: job_recruitment
User: applynow_user
Region: Singapore (same as web service)
```

3. Chọn **Free** plan
4. Click **"Create Database"**

### 4.2. Đợi database khởi tạo

Mất khoảng 2-3 phút.

---

## 🔗 BƯỚC 5: Kết nối Database với Web Service

### 5.1. Lấy Database URL

1. Vào PostgreSQL database vừa tạo
2. Scroll xuống phần **"Connections"**
3. Copy **"Internal Database URL"** (bắt đầu bằng `postgres://`)

### 5.2. Thêm vào Web Service

1. Vào Web Service **applynow**
2. Click tab **"Environment"** (bên trái)
3. Click **"Add Environment Variable"**
4. Thêm:

```
Key: DATABASE_URL
Value: [Paste Internal Database URL vừa copy]
```

5. Click **"Save Changes"**

Service sẽ tự động restart!

---

## 📊 BƯỚC 6: Import Database Schema

### 6.1. Kết nối đến PostgreSQL

Có 2 cách:

#### Cách 1: Dùng Render Shell (Dễ nhất)

1. Vào PostgreSQL database
2. Click tab **"Shell"**
3. Chạy lệnh:

```sql
-- Tạo bảng Users
CREATE TABLE NguoiDung (
    ID_NguoiDung SERIAL PRIMARY KEY,
    Email VARCHAR(255) UNIQUE NOT NULL,
    MatKhau VARCHAR(255) NOT NULL,
    VaiTro VARCHAR(50) NOT NULL,
    TrangThai VARCHAR(50) DEFAULT 'active',
    NgayTao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    LanDangNhapCuoi TIMESTAMP
);

-- Thêm các bảng khác...
```

#### Cách 2: Dùng psql (Command line)

```bash
# Copy External Database URL từ Render
psql [EXTERNAL_DATABASE_URL]

# Sau đó paste SQL commands
```

### 6.2. Import dữ liệu mẫu

Tương tự, chạy các INSERT statements từ `database/seed.sql`

**LƯU Ý:** Cần convert một số syntax từ MySQL sang PostgreSQL:
- `AUTO_INCREMENT` → `SERIAL`
- `DATETIME` → `TIMESTAMP`
- Backticks `` ` `` → Double quotes `"`

---

## ✅ BƯỚC 7: Kiểm tra

### 7.1. Xem Logs

1. Vào Web Service
2. Click tab **"Logs"**
3. Xem có lỗi gì không

### 7.2. Truy cập website

URL sẽ có dạng: `https://applynow.onrender.com`

### 7.3. Test các chức năng

- [ ] Trang chủ load được
- [ ] Đăng ký tài khoản
- [ ] Đăng nhập
- [ ] Tìm kiếm việc làm

---

## 🐛 KHẮC PHỤC LỖI THƯỜNG GẶP

### Lỗi: "Application failed to respond"

**Nguyên nhân:** Port không đúng

**Giải pháp:**
1. Vào Environment Variables
2. Thêm: `PORT = 80`
3. Save và restart

### Lỗi: "Database connection failed"

**Nguyên nhân:** DATABASE_URL chưa đúng

**Giải pháp:**
1. Kiểm tra DATABASE_URL trong Environment
2. Đảm bảo dùng **Internal Database URL**
3. Format: `postgres://user:pass@host:port/dbname`

### Lỗi: "Build failed"

**Nguyên nhân:** Dockerfile có vấn đề

**Giải pháp:**
1. Xem logs chi tiết
2. Kiểm tra Dockerfile syntax
3. Đảm bảo đã push Dockerfile lên GitHub

### Lỗi: "502 Bad Gateway"

**Nguyên nhân:** Service chưa start xong

**Giải pháp:**
- Đợi thêm 1-2 phút
- Xem logs để biết tiến trình

---

## 📝 CHECKLIST HOÀN THÀNH

- [ ] Đã push Dockerfile, composer.json, Procfile lên GitHub
- [ ] Đã tạo Web Service với Docker environment
- [ ] Đã tạo PostgreSQL database
- [ ] Đã kết nối DATABASE_URL
- [ ] Đã import schema
- [ ] Đã import seed data
- [ ] Website truy cập được
- [ ] Đăng nhập hoạt động
- [ ] Upload file hoạt động

---

## 🎯 KẾT QUẢ MONG ĐỢI

Sau khi hoàn thành, bạn sẽ có:

✅ Website chạy tại: `https://applynow.onrender.com`  
✅ Database PostgreSQL hoạt động  
✅ Auto deploy khi push GitHub  
✅ SSL/HTTPS miễn phí  
✅ Logs real-time  

---

## 🔄 CẬP NHẬT SAU NÀY

Mỗi khi sửa code:

```bash
git add .
git commit -m "Your changes"
git push
```

Render sẽ tự động:
1. Pull code mới
2. Build Docker image
3. Deploy
4. Restart service

---

## 💡 MẸO HAY

### Giữ service không sleep (Free tier)

Dùng **UptimeRobot**:
1. Đăng ký: https://uptimerobot.com (miễn phí)
2. Thêm monitor:
   - Type: HTTP(s)
   - URL: https://applynow.onrender.com
   - Interval: 5 minutes
3. Service sẽ luôn active!

### Xem logs real-time

```bash
# Install Render CLI
npm install -g @render/cli

# Login
render login

# View logs
render logs -f applynow
```

---

## 📞 CẦN TRỢ GIÚP?

Nếu gặp vấn đề:

1. **Check logs** - Luôn xem logs trước
2. **Check Environment Variables** - Đảm bảo DATABASE_URL đúng
3. **Check GitHub** - Code đã push chưa
4. **Restart service** - Thử restart thủ công

---

**Chúc bạn deploy thành công! 🎉**

*Nếu cần hỗ trợ thêm, hãy gửi logs cho tôi!*
