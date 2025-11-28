<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Job Portal - Tìm việc làm' ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="<?= BASE_URL ?>/">Job Portal</a>
                </div>
                <ul class="nav-menu">
                    <li><a href="<?= BASE_URL ?>/jobs">
                        <i class="fas fa-search"></i> Tìm việc làm
                    </a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['user_role'] === 'APPLICANT'): ?>
                            <li><a href="<?= BASE_URL ?>/applicant/dashboard">
                                <i class="fas fa-home"></i> Dashboard
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/applicant/profile">
                                <i class="fas fa-user"></i> Hồ sơ
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/applicant/applications">
                                <i class="fas fa-file-alt"></i> Đơn ứng tuyển
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/applicant/saved-jobs">
                                <i class="fas fa-heart"></i> Việc đã lưu
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/support">
                                <i class="fas fa-headset"></i> Hỗ trợ
                            </a></li>
                        <?php elseif ($_SESSION['user_role'] === 'EMPLOYER'): ?>
                            <li><a href="<?= BASE_URL ?>/employer/dashboard">
                                <i class="fas fa-home"></i> Dashboard
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/employer/jobs">
                                <i class="fas fa-briefcase"></i> Quản lý tin
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/employer/applications">
                                <i class="fas fa-users"></i> Ứng viên
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/support">
                                <i class="fas fa-headset"></i> Hỗ trợ
                            </a></li>
                        <?php elseif ($_SESSION['user_role'] === 'ADMIN'): ?>
                            <li><a href="<?= BASE_URL ?>/admin/dashboard">
                                <i class="fas fa-tachometer-alt"></i> Quản trị
                            </a></li>
                            <li><a href="<?= BASE_URL ?>/admin/support">
                                <i class="fas fa-headset"></i> Hỗ trợ
                            </a></li>
                        <?php endif; ?>
                        <li><a href="<?= BASE_URL ?>/logout" class="btn-primary">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>/login">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a></li>
                        <li><a href="<?= BASE_URL ?>/register" class="btn-primary">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="main-content">
        <?php if (hasFlash('success')): ?>
            <div class="container">
                <div class="alert alert-success" style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                    <span><?= e(getFlash('success')) ?></span>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (hasFlash('error')): ?>
            <div class="container">
                <div class="alert alert-error" style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i>
                    <span><?= e(getFlash('error')) ?></span>
                </div>
            </div>
        <?php endif; ?>
