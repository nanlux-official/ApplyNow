@echo off
chcp 65001 >nul
echo ========================================
echo    CÀI ĐẶT HỆ THỐNG TUYỂN DỤNG - XAMPP
echo ========================================
echo.

REM Kiểm tra quyền admin
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo [LỖI] Vui lòng chạy file này với quyền Administrator!
    echo Nhấn chuột phải vào file và chọn "Run as administrator"
    pause
    exit /b 1
)

echo [1/6] Kiểm tra XAMPP...
if not exist "C:\xampp\mysql\bin\mysql.exe" (
    echo [LỖI] Không tìm thấy XAMPP!
    echo Vui lòng cài đặt XAMPP tại: https://www.apachefriends.org/
    pause
    exit /b 1
)
echo ✓ Đã tìm thấy XAMPP

echo.
echo [2/6] Kiểm tra MySQL đang chạy...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ MySQL đang chạy
) else (
    echo [CẢNH BÁO] MySQL chưa chạy. Đang khởi động...
    start "" "C:\xampp\mysql_start.bat"
    timeout /t 5 /nobreak >nul
)

echo.
echo [3/6] Nhập thông tin cấu hình...
set /p DB_HOST="Nhập MySQL Host (mặc định: localhost): "
if "%DB_HOST%"=="" set DB_HOST=localhost

set /p DB_USER="Nhập MySQL User (mặc định: root): "
if "%DB_USER%"=="" set DB_USER=root

set /p DB_PASS="Nhập MySQL Password (để trống nếu không có): "

set /p DB_NAME="Nhập tên Database (mặc định: job_recruitment): "
if "%DB_NAME%"=="" set DB_NAME=job_recruitment

echo.
echo [4/6] Tạo database và import dữ liệu...

REM Tạo database
echo DROP DATABASE IF EXISTS %DB_NAME%; > temp_create_db.sql
echo CREATE DATABASE %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; >> temp_create_db.sql

if "%DB_PASS%"=="" (
    "C:\xampp\mysql\bin\mysql.exe" -h %DB_HOST% -u %DB_USER% < temp_create_db.sql
) else (
    "C:\xampp\mysql\bin\mysql.exe" -h %DB_HOST% -u %DB_USER% -p%DB_PASS% < temp_create_db.sql
)

if %errorLevel% neq 0 (
    echo [LỖI] Không thể tạo database!
    del temp_create_db.sql
    pause
    exit /b 1
)
del temp_create_db.sql
echo ✓ Đã tạo database: %DB_NAME%

REM Import schema
echo Đang import schema...
if "%DB_PASS%"=="" (
    "C:\xampp\mysql\bin\mysql.exe" -h %DB_HOST% -u %DB_USER% %DB_NAME% < database\schema.sql
) else (
    "C:\xampp\mysql\bin\mysql.exe" -h %DB_HOST% -u %DB_USER% -p%DB_PASS% %DB_NAME% < database\schema.sql
)

if %errorLevel% neq 0 (
    echo [LỖI] Không thể import schema!
    pause
    exit /b 1
)
echo ✓ Đã import schema

REM Import seed data
echo Đang import dữ liệu mẫu...
if "%DB_PASS%"=="" (
    "C:\xampp\mysql\bin\mysql.exe" -h %DB_HOST% -u %DB_USER% %DB_NAME% < database\seed.sql
) else (
    "C:\xampp\mysql\bin\mysql.exe" -h %DB_HOST% -u %DB_USER% -p%DB_PASS% %DB_NAME% < database\seed.sql
)

if %errorLevel% neq 0 (
    echo [CẢNH BÁO] Không thể import dữ liệu mẫu (có thể bỏ qua)
) else (
    echo ✓ Đã import dữ liệu mẫu
)

echo.
echo [5/6] Cấu hình file config...

REM Tạo file config/database.php
(
echo ^<?php
echo // Cấu hình database - Tự động tạo bởi setup-xampp.bat
echo define^('DB_HOST', '%DB_HOST%'^);
echo define^('DB_USER', '%DB_USER%'^);
echo define^('DB_PASS', '%DB_PASS%'^);
echo define^('DB_NAME', '%DB_NAME%'^);
echo define^('DB_CHARSET', 'utf8mb4'^);
) > config\database.php

echo ✓ Đã tạo config/database.php

REM Kiểm tra và tạo thư mục uploads
echo.
echo [6/6] Tạo thư mục uploads...
if not exist "public\uploads" mkdir "public\uploads"
if not exist "public\uploads\cv" mkdir "public\uploads\cv"
if not exist "public\uploads\logo" mkdir "public\uploads\logo"
if not exist "public\uploads\avatar" mkdir "public\uploads\avatar"
echo ✓ Đã tạo thư mục uploads

echo.
echo ========================================
echo           CÀI ĐẶT HOÀN TẤT!
echo ========================================
echo.
echo Thông tin hệ thống:
echo - Database: %DB_NAME%
echo - Host: %DB_HOST%
echo - User: %DB_USER%
echo.
echo Tài khoản mặc định:
echo.
echo [ADMIN]
echo   Email: admin@jobsite.com
echo   Password: admin123
echo.
echo [NHÀ TUYỂN DỤNG]
echo   Email: employer@company.com
echo   Password: employer123
echo.
echo [ỨNG VIÊN]
echo   Email: applicant@email.com
echo   Password: applicant123
echo.
echo Để chạy ứng dụng:
echo 1. Đảm bảo Apache và MySQL đang chạy trong XAMPP
echo 2. Copy thư mục này vào C:\xampp\htdocs\
echo 3. Truy cập: http://localhost/[tên-thư-mục]/public
echo.
echo Ví dụ: http://localhost/job-recruitment/public
echo.
pause
