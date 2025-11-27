@echo off
chcp 65001 >nul
echo ========================================
echo      KIỂM TRA HỆ THỐNG
echo ========================================
echo.

set ERROR_COUNT=0

echo [1] Kiểm tra XAMPP...
if exist "C:\xampp\mysql\bin\mysql.exe" (
    echo ✓ XAMPP đã cài đặt
) else (
    echo ✗ XAMPP chưa cài đặt
    set /a ERROR_COUNT+=1
)

echo.
echo [2] Kiểm tra MySQL đang chạy...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ MySQL đang chạy
) else (
    echo ✗ MySQL chưa chạy
    set /a ERROR_COUNT+=1
)

echo.
echo [3] Kiểm tra Apache đang chạy...
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ Apache đang chạy
) else (
    echo ✗ Apache chưa chạy
    set /a ERROR_COUNT+=1
)

echo.
echo [4] Kiểm tra file cấu hình...
if exist "config\database.php" (
    echo ✓ File config/database.php tồn tại
) else (
    echo ✗ File config/database.php không tồn tại
    set /a ERROR_COUNT+=1
)

if exist "config\config.php" (
    echo ✓ File config/config.php tồn tại
) else (
    echo ✗ File config/config.php không tồn tại
    set /a ERROR_COUNT+=1
)

echo.
echo [5] Kiểm tra thư mục uploads...
if exist "public\uploads" (
    echo ✓ Thư mục public/uploads tồn tại
) else (
    echo ✗ Thư mục public/uploads không tồn tại
    set /a ERROR_COUNT+=1
)

if exist "public\uploads\cv" (
    echo ✓ Thư mục public/uploads/cv tồn tại
) else (
    echo ✗ Thư mục public/uploads/cv không tồn tại
    set /a ERROR_COUNT+=1
)

if exist "public\uploads\logo" (
    echo ✓ Thư mục public/uploads/logo tồn tại
) else (
    echo ✗ Thư mục public/uploads/logo không tồn tại
    set /a ERROR_COUNT+=1
)

if exist "public\uploads\avatar" (
    echo ✓ Thư mục public/uploads/avatar tồn tại
) else (
    echo ✗ Thư mục public/uploads/avatar không tồn tại
    set /a ERROR_COUNT+=1
)

echo.
echo [6] Kiểm tra file .htaccess...
if exist "public\.htaccess" (
    echo ✓ File public/.htaccess tồn tại
) else (
    echo ✗ File public/.htaccess không tồn tại
    set /a ERROR_COUNT+=1
)

echo.
echo [7] Kiểm tra database...
if exist "config\database.php" (
    echo Đang kiểm tra kết nối database...
    
    REM Đọc thông tin từ config
    for /f "tokens=2 delims=')" %%a in ('findstr "DB_NAME" config\database.php') do set DB_NAME=%%a
    for /f "tokens=2 delims=')" %%a in ('findstr "DB_USER" config\database.php') do set DB_USER=%%a
    
    REM Loại bỏ dấu nháy và khoảng trắng
    set DB_NAME=%DB_NAME:'=%
    set DB_NAME=%DB_NAME: =%
    set DB_USER=%DB_USER:'=%
    set DB_USER=%DB_USER: =%
    
    if exist "C:\xampp\mysql\bin\mysql.exe" (
        "C:\xampp\mysql\bin\mysql.exe" -u %DB_USER% -e "USE %DB_NAME%; SELECT COUNT(*) FROM NguoiDung;" >nul 2>&1
        if %errorLevel% equ 0 (
            echo ✓ Kết nối database thành công
            echo ✓ Bảng NguoiDung tồn tại
        ) else (
            echo ✗ Không thể kết nối database hoặc bảng chưa được tạo
            set /a ERROR_COUNT+=1
        )
    )
) else (
    echo ✗ Không thể kiểm tra database (thiếu config)
    set /a ERROR_COUNT+=1
)

echo.
echo ========================================
echo           KẾT QUẢ KIỂM TRA
echo ========================================
echo.

if %ERROR_COUNT% equ 0 (
    echo ✓✓✓ HỆ THỐNG HOẠT ĐỘNG BÌNH THƯỜNG ✓✓✓
    echo.
    echo Bạn có thể truy cập:
    echo http://localhost/[tên-thư-mục]/public
    echo.
    echo Tài khoản mặc định:
    echo - Admin: admin@jobsite.com / admin123
    echo - Employer: employer@company.com / employer123
    echo - Applicant: applicant@email.com / applicant123
) else (
    echo ✗✗✗ PHÁT HIỆN %ERROR_COUNT% LỖI ✗✗✗
    echo.
    echo Vui lòng:
    echo 1. Chạy setup-xampp.bat với quyền Administrator
    echo 2. Đảm bảo XAMPP đã cài đặt và chạy
    echo 3. Xem file QUICK_START.md để biết thêm chi tiết
)

echo.
pause
