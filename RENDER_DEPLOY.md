# 🚀 HƯỚNG DẪN DEPLOY LÊN RENDER.COM

## 🎯 Tại sao chọn Render.com?

✅ **Hỗ trợ PHP** - Chạy PHP native  
✅ **MySQL/PostgreSQL** - Database miễn phí  
✅ **Free tier** - 750 giờ/tháng miễn phí  
✅ **Auto deploy** - Tự động deploy khi push GitHub  
✅ **SSL miễn phí** - HTTPS tự động  
✅ **Persistent storage** - Lưu trữ file upload  

## 📋 Yêu cầu

- ✅ Code đã push lên GitHub
- ✅ Tài khoản Render.com (đăng ký miễn phí)

---

## 🔧 BƯỚC 1: Chuẩn bị code

### 1.1. Tạo file cấu hình cho Render

File `render.yaml` đã được tạo sẵn trong project.

### 1.2. Cập nhật config để hỗ trợ environment variables

Chỉnh sửa `config/database.php` để đọc từ environment:

```php
<?php
// Đọc từ environment variables (Render) hoặc file config (Local)
if (getenv('DATABASE_URL')) {
    // Parse DATABASE_URL từ Render
    $db_url = parse_url(getenv('DATABASE_URL'));
    define('DB_HOST', $db_url['host']);
    define('DB_USER', $db_url['user']);
    define('DB_PASS', $db_url['pass']);
    define('DB_NAME', ltrim($db_url['path'], '/'));
    define('DB_PORT', $db_url['port'] ?? 3306);
} else {
    // Local development
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'job_recruitment');
    define('DB_PORT', 3306);
}
define('DB_CHARSET', 'utf8mb4');
```

---

## 🚀 BƯỚC 2: Deploy lên Render

### 2.1. Đăng ký Render.com

1. Truy cập: https://render.com/
2. Click **"Get Started"**
3. Đăng ký bằng GitHub account

### 2.2. Tạo Web Service

1. Vào Dashboard: https://dashboard.render.com/
2. Click **"New +"** → **"Web Service"**
3. Connect GitHub repository: `nanlux-official/ApplyNow`
4. Điền thông tin:

```
Name: applynow
Region: Singapore (gần Việt Nam nhất)
Branch: main
Root Directory: (để trống)
Runtime: PHP
Build Command: (để trống)
Start Command: php -S 0.0.0.0:$PORT -t public
```

5. Chọn **Free** plan
6. Click **"Create Web Service"**

### 2.3. Tạo Database

1. Vào Dashboard → Click **"New +"** → **"PostgreSQL"**
   (Render free tier chỉ có PostgreSQL, không có MySQL)
2. Điền thông tin:

```
Name: applynow-db
Database: job_recruitment
User: applynow_user
Region: Singapore
```

3. Chọn **Free** plan
4. Click **"Create Database"**

### 2.4. Kết nối Database với Web Service

1. Vào Web Service → **Environment**
2. Thêm environment variable:

```
Key: DATABASE_URL
Value: [Copy từ PostgreSQL Internal Database URL]
```

3. Click **"Save Changes"**

---

## 🗄️ BƯỚC 3: Import Database

### 3.1. Kết nối đến PostgreSQL

Render cung cấp **External Database URL**, copy và dùng tool như:
- **pgAdmin** (GUI)
- **psql** (CLI)
- **DBeaver** (Universal)

### 3.2. Chuyển đổi MySQL sang PostgreSQL

Vì Render free tier chỉ có PostgreSQL, bạn cần convert schema:

**Thay đổi chính:**
```sql
-- MySQL
AUTO_INCREMENT

-- PostgreSQL
SERIAL hoặc BIGSERIAL

-- MySQL
DATETIME

-- PostgreSQL
TIMESTAMP
```

### 3.3. Import schema

```bash
# Kết nối và import
psql [EXTERNAL_DATABASE_URL] < database/schema_postgres.sql
```

---

## 📤 BƯỚC 4: Cấu hình File Upload

### 4.1. Tạo Persistent Disk

1. Vào Web Service → **Settings** → **Disks**
2. Click **"Add Disk"**
3. Điền:

```
Name: uploads
Mount Path: /opt/render/project/src/public/uploads
Size: 1 GB (free)
```

4. Click **"Save"**

---

## ✅ BƯỚC 5: Kiểm tra & Test

### 5.1. Truy cập website

URL sẽ có dạng: `https://applynow.onrender.com`

### 5.2. Test các chức năng

- [ ] Đăng ký/Đăng nhập
- [ ] Tìm kiếm việc làm
- [ ] Upload CV
- [ ] Đăng tin tuyển dụng
- [ ] Upload logo

---

## 🔄 BƯỚC 6: Auto Deploy

Mỗi khi bạn push code lên GitHub:

```bash
git add .
git commit -m "Update features"
git push
```

Render sẽ tự động:
1. Pull code mới
2. Build lại
3. Deploy
4. Restart service

---

## ⚙️ CẤU HÌNH NÂNG CAO

### Environment Variables cần thiết

```
DATABASE_URL=postgresql://user:pass@host:port/dbname
BASE_URL=https://applynow.onrender.com
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password
```

### Custom Domain (Tùy chọn)

1. Vào **Settings** → **Custom Domain**
2. Thêm domain của bạn
3. Cấu hình DNS theo hướng dẫn

---

## 🆓 GIỚI HẠN FREE TIER

### Render Free Plan:
- ✅ 750 giờ/tháng
- ✅ 512 MB RAM
- ✅ PostgreSQL 1GB
- ✅ SSL miễn phí
- ⚠️ Sleep sau 15 phút không hoạt động
- ⚠️ Khởi động lại mất ~30s

### Giải pháp cho Sleep:
- Dùng **UptimeRobot** để ping mỗi 5 phút
- Hoặc nâng cấp lên **Starter Plan** ($7/tháng)

---

## 🔧 KHẮC PHỤC SỰ CỐ

### Lỗi: "Build failed"
```bash
# Kiểm tra logs
# Vào Deploy → View Logs
```

### Lỗi: "Database connection failed"
```bash
# Kiểm tra DATABASE_URL
# Vào Environment → Check DATABASE_URL
```

### Lỗi: "File upload failed"
```bash
# Kiểm tra Disk đã mount chưa
# Vào Settings → Disks
```

---

## 📊 MONITORING

### Xem Logs
```
Dashboard → Service → Logs
```

### Xem Metrics
```
Dashboard → Service → Metrics
- CPU Usage
- Memory Usage
- Request Count
```

---

## 💰 CHI PHÍ (Nếu nâng cấp)

### Starter Plan ($7/month):
- No sleep
- 512 MB RAM
- Faster builds

### Standard Plan ($25/month):
- 2 GB RAM
- Priority support

### PostgreSQL Paid:
- $7/month: 1 GB
- $20/month: 10 GB

---

## 🎯 KHUYẾN NGHỊ

### Cho Development/Testing:
✅ **Render Free Tier** - Đủ dùng, có database

### Cho Production:
✅ **Render Starter** ($7/month) - Không sleep
✅ **Railway** ($5/month) - Tương tự Render
✅ **DigitalOcean App Platform** ($5/month)
✅ **Heroku** ($7/month) - Ổn định nhất

### Cho Enterprise:
✅ **AWS Elastic Beanstalk**
✅ **Google Cloud Run**
✅ **Azure App Service**

---

## 🔗 LINKS HỮU ÍCH

- Render Docs: https://render.com/docs
- Render Dashboard: https://dashboard.render.com
- PostgreSQL Docs: https://www.postgresql.org/docs/

---

## ✅ CHECKLIST DEPLOY

- [ ] Code đã push lên GitHub
- [ ] Đã tạo Render account
- [ ] Đã tạo Web Service
- [ ] Đã tạo PostgreSQL database
- [ ] Đã kết nối database với web service
- [ ] Đã import schema
- [ ] Đã import seed data
- [ ] Đã tạo persistent disk cho uploads
- [ ] Đã test đăng ký/đăng nhập
- [ ] Đã test upload file
- [ ] Đã cấu hình email (nếu cần)

---

**Chúc bạn deploy thành công! 🚀**

*Nếu gặp vấn đề, hãy check logs trên Render Dashboard.*
