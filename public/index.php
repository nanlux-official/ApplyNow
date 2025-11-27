<?php
// Entry point của ứng dụng

// Bắt đầu session
session_start();

// Load cấu hình
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Load core classes
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Middleware.php';

// Load utilities
require_once BASE_PATH . '/utils/helpers.php';
require_once BASE_PATH . '/utils/validation.php';
require_once BASE_PATH . '/utils/email.php';

// Load models
require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/models/Applicant.php';
require_once BASE_PATH . '/models/Employer.php';
require_once BASE_PATH . '/models/Job.php';
require_once BASE_PATH . '/models/Application.php';
require_once BASE_PATH . '/models/Notification.php';
require_once BASE_PATH . '/models/Review.php';
require_once BASE_PATH . '/models/SavedJob.php';
require_once BASE_PATH . '/models/AdminLog.php';
require_once BASE_PATH . '/models/SupportTicket.php';

// Load controllers
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/JobController.php';
require_once BASE_PATH . '/controllers/AdminController.php';
require_once BASE_PATH . '/controllers/EmployerController.php';
require_once BASE_PATH . '/controllers/ApplicantController.php';
require_once BASE_PATH . '/controllers/SupportController.php';

// Khởi tạo router
$router = new Router();

// ==================== PUBLIC ROUTES ====================

// Trang chủ
$router->get('/', [JobController::class, 'index']);
$router->get('/jobs', [JobController::class, 'index']);
$router->get('/jobs/:id', [JobController::class, 'detail']);
$router->get('/jobs/:id/apply', [JobController::class, 'showApply']);
$router->post('/jobs/:id/apply', [JobController::class, 'apply']);
$router->post('/jobs/:id/save', [JobController::class, 'save']);

// Auth routes
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/verify-email', [AuthController::class, 'verifyEmail']);
$router->get('/forgot-password', [AuthController::class, 'showForgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->get('/reset-password', [AuthController::class, 'showResetPassword']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);

// ==================== APPLICANT ROUTES ====================
$router->get('/applicant/dashboard', [ApplicantController::class, 'dashboard']);
$router->get('/applicant/profile', [ApplicantController::class, 'profile']);
$router->post('/applicant/profile', [ApplicantController::class, 'updateProfile']);
$router->post('/applicant/change-password', [ApplicantController::class, 'changePassword']);
$router->get('/applicant/applications', [ApplicantController::class, 'applications']);
$router->get('/applicant/applications/:id', [ApplicantController::class, 'applicationDetail']);
$router->post('/applicant/applications/:id/delete', [ApplicantController::class, 'deleteApplication']);
$router->get('/applicant/saved-jobs', [ApplicantController::class, 'savedJobs']);
$router->post('/applicant/saved-jobs/:id/remove', [ApplicantController::class, 'removeSavedJob']);
$router->get('/applicant/notifications', [ApplicantController::class, 'notifications']);
$router->post('/applicant/review/:id', [ApplicantController::class, 'reviewEmployer']);
$router->get('/employer/:id/reviews', [JobController::class, 'employerReviews']);

// ==================== EMPLOYER ROUTES ====================
$router->get('/employer/dashboard', [EmployerController::class, 'dashboard']);
$router->get('/employer/jobs', [EmployerController::class, 'manageJobs']);
$router->get('/employer/jobs/create', [EmployerController::class, 'showPostJob']);
$router->post('/employer/jobs/create', [EmployerController::class, 'postJob']);
$router->get('/employer/jobs/:id/edit', [EmployerController::class, 'showEditJob']);
$router->post('/employer/jobs/:id/update', [EmployerController::class, 'updateJob']);
$router->post('/employer/jobs/:id/delete', [EmployerController::class, 'deleteJob']);
$router->get('/employer/applications', [EmployerController::class, 'manageApplications']);
$router->get('/employer/applications/:id', [EmployerController::class, 'applicationDetail']);
$router->post('/employer/applications/:id/status', [EmployerController::class, 'updateApplicationStatus']);
$router->post('/employer/applications/:id/delete', [EmployerController::class, 'deleteApplication']);
$router->get('/employer/profile', [EmployerController::class, 'profile']);
$router->post('/employer/profile', [EmployerController::class, 'updateProfile']);
$router->post('/employer/profile/upload-logo', [EmployerController::class, 'uploadLogo']);
$router->post('/employer/change-password', [EmployerController::class, 'changePassword']);

// ==================== ADMIN ROUTES ====================
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/users/:id', [AdminController::class, 'userDetail']);
$router->get('/admin/users/:id/edit', [AdminController::class, 'showEditUser']);
$router->post('/admin/users/:id/update', [AdminController::class, 'updateUser']);
$router->post('/admin/users/:id/status', [AdminController::class, 'updateUserStatus']);
$router->post('/admin/users/:id/change-role', [AdminController::class, 'changeUserRole']);
$router->post('/admin/users/:id/delete', [AdminController::class, 'deleteUser']);
$router->get('/admin/jobs', [AdminController::class, 'jobs']);
$router->get('/admin/jobs/:id/edit', [AdminController::class, 'showEditJob']);
$router->post('/admin/jobs/:id/update', [AdminController::class, 'updateJob']);
$router->post('/admin/jobs/:id/status', [AdminController::class, 'toggleJobStatus']);
$router->post('/admin/jobs/:id/delete', [AdminController::class, 'deleteJob']);
$router->get('/admin/support', [SupportController::class, 'adminList']);
$router->post('/admin/support/:id/status', [SupportController::class, 'updateStatus']);

// ==================== SUPPORT ROUTES ====================
$router->get('/support', [SupportController::class, 'myTickets']);
$router->get('/support/create', [SupportController::class, 'create']);
$router->post('/support/create', [SupportController::class, 'store']);
$router->get('/support/tickets/:id', [SupportController::class, 'detail']);
$router->post('/support/tickets/:id/reply', [SupportController::class, 'addReply']);
$router->get('/support/upgrade-employer', [SupportController::class, 'showUpgradeEmployer']);
$router->post('/support/upgrade-employer', [SupportController::class, 'submitUpgradeEmployer']);

// ==================== API ROUTES ====================
$router->post('/api/jobs/:id/save', [JobController::class, 'save']);
$router->post('/api/jobs/:id/unsave', [JobController::class, 'unsave']);

// Dispatch router
$router->dispatch();
