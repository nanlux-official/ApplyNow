<?php require_once BASE_PATH . '/views/layouts/header.php'; ?>

<style>
@keyframes slideIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.hero-section {
    background: #F9FAFB;
    padding: 3rem 0;
    margin-bottom: 2rem;
    border-bottom: 1px solid #E5E7EB;
}

.search-box {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    animation: slideIn 0.5s ease;
}

.job-card-modern {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border: 1px solid #E5E7EB;
    transition: all 0.3s ease;
    animation: slideIn 0.6s ease;
}

.job-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    border-color: #3B82F6;
}

.tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.75rem;
    background: #F3F4F6;
    border-radius: 6px;
    font-size: 0.875rem;
    color: #374151;
    font-weight: 500;
}

.company-logo {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    background: #F3F4F6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    color: #6B7280;
    flex-shrink: 0;
}

.filter-chip {
    padding: 0.5rem 1rem;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    background: white;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.filter-chip:hover {
    border-color: #3B82F6;
    background: #EFF6FF;
}
</style>

<div class="hero-section">
    <div class="container">
        <!-- Stats Bar -->
        <div style="display: flex; justify-content: center; gap: 3rem; margin-bottom: 2rem; flex-wrap: wrap;">
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 800; color: #3B82F6;"><?= $pagination['total_items'] ?>+</div>
                <div style="color: #6B7280; font-size: 0.875rem; font-weight: 500;">Việc làm</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 800; color: #10B981;">500+</div>
                <div style="color: #6B7280; font-size: 0.875rem; font-weight: 500;">Công ty</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 800; color: #F59E0B;">1000+</div>
                <div style="color: #6B7280; font-size: 0.875rem; font-weight: 500;">Ứng viên</div>
            </div>
        </div>

        <h1 style="font-size: 2.75rem; font-weight: 800; color: #111827; margin-bottom: 0.75rem; text-align: center; line-height: 1.2;">
            Tìm kiếm việc làm <span style="color: #3B82F6;">mơ ước</span> của bạn
        </h1>
        <p style="text-align: center; color: #6B7280; font-size: 1.125rem; margin-bottom: 2.5rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Khám phá hàng nghìn cơ hội nghề nghiệp từ các công ty hàng đầu. Bắt đầu hành trình sự nghiệp của bạn ngay hôm nay!
        </p>
        
        <div class="search-box">
            <form method="GET" action="<?= BASE_URL ?>/jobs">
                <div style="display: grid; grid-template-columns: 2fr 1.5fr auto; gap: 1rem; margin-bottom: 1rem;">
                    <input type="text" name="keyword" placeholder="🔍 Từ khóa, vị trí công việc..." 
                           value="<?= e($filters['keyword'] ?? '') ?>"
                           style="padding: 0.875rem 1rem; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 1rem;">
                    
                    <input type="text" name="dia_diem" placeholder="📍 Địa điểm" 
                           value="<?= e($filters['dia_diem'] ?? '') ?>"
                           style="padding: 0.875rem 1rem; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 1rem;">
                    
                    <button type="submit" class="btn btn-primary" style="padding: 0.875rem 2rem; font-weight: 600; border-radius: 10px;">
                        Tìm kiếm
                    </button>
                </div>
                
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <select name="loai_cong_viec" class="filter-chip">
                        <option value="">⏰ Loại công việc</option>
                        <option value="Full-time" <?= ($filters['loai_cong_viec'] ?? '') === 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                        <option value="Part-time" <?= ($filters['loai_cong_viec'] ?? '') === 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                        <option value="Thực tập" <?= ($filters['loai_cong_viec'] ?? '') === 'Thực tập' ? 'selected' : '' ?>>Thực tập</option>
                        <option value="Freelance" <?= ($filters['loai_cong_viec'] ?? '') === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                    </select>
                    
                    <select name="kinh_nghiem" class="filter-chip">
                        <option value="">💼 Kinh nghiệm</option>
                        <option value="Chưa có">Chưa có kinh nghiệm</option>
                        <option value="1">Dưới 1 năm</option>
                        <option value="1-2">1-2 năm</option>
                        <option value="2-3">2-3 năm</option>
                        <option value="3-5">3-5 năm</option>
                        <option value="5+">Trên 5 năm</option>
                    </select>
                    
                    <select name="sort" class="filter-chip">
                        <option value="">🔄 Sắp xếp</option>
                        <option value="latest" <?= ($filters['sort'] ?? '') === 'latest' ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="salary_desc" <?= ($filters['sort'] ?? '') === 'salary_desc' ? 'selected' : '' ?>>Lương cao nhất</option>
                        <option value="views_desc" <?= ($filters['sort'] ?? '') === 'views_desc' ? 'selected' : '' ?>>Xem nhiều nhất</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- All Jobs Section -->
<div class="container" style="margin-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827;">
            💼 Tất cả công việc <span style="color: #3B82F6;">(<?= $pagination['total_items'] ?>)</span>
        </h2>
    </div>
    
    <?php if (empty($jobs)): ?>
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
            <h3 style="color: #6B7280; font-size: 1.25rem;">Không tìm thấy công việc phù hợp</h3>
            <p style="color: #9CA3AF; margin-top: 0.5rem;">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;">
            <?php foreach ($jobs as $job): ?>
                <div style="background: white; border-radius: 12px; padding: 1.25rem; border: 1px solid #E5E7EB; transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.1)'; this.style.borderColor='#3B82F6';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#E5E7EB';">
                    
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 8px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #6B7280; flex-shrink: 0;">
                            <?php if ($job['Logo']): ?>
                                <img src="<?= ASSETS_URL ?>/uploads/<?= e($job['Logo']) ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <?= strtoupper(substr($job['ten_cong_ty'], 0, 2)) ?>
                            <?php endif; ?>
                        </div>
                        
                        <div style="flex: 1; min-width: 0;">
                            <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.25rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">
                                <a href="<?= BASE_URL ?>/jobs/<?= e($job['ID_BaiDang']) ?>" style="color: inherit; text-decoration: none;">
                                    <?= e($job['TieuDe']) ?>
                                </a>
                            </h3>
                            <p style="color: #6B7280; font-size: 0.875rem; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= e($job['ten_cong_ty']) ?>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6B7280;">
                            <span>💰</span>
                            <span style="font-weight: 500;"><?= formatMoney($job['MucLuong']) ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6B7280;">
                            <span>📍</span>
                            <span><?= e($job['DiaDiem']) ?></span>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #F3F4F6;">
                        <span style="color: #9CA3AF; font-size: 0.75rem;">
                            <?= timeAgo($job['NgayDangTin']) ?>
                        </span>
                        <button style="background: none; border: none; cursor: pointer; color: #10B981; font-size: 1.25rem; padding: 0; transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.2)'"
                                onmouseout="this.style.transform='scale(1)'">
                            ♥
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($pagination['total_pages'] > 1): ?>
        <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem; padding: 2rem 0;">
            <?php if ($pagination['has_prev']): ?>
                <a href="?page=<?= $pagination['current_page'] - 1 ?><?= http_build_query($filters) ? '&' . http_build_query($filters) : '' ?>" 
                   class="btn btn-secondary" style="padding: 0.75rem 1.5rem; border-radius: 10px;">
                    ← Trước
                </a>
            <?php endif; ?>
            
            <span style="padding: 0.75rem 1.5rem; background: white; border-radius: 10px; font-weight: 600; color: #374151; border: 2px solid #E5E7EB;">
                Trang <?= $pagination['current_page'] ?> / <?= $pagination['total_pages'] ?>
            </span>
            
            <?php if ($pagination['has_next']): ?>
                <a href="?page=<?= $pagination['current_page'] + 1 ?><?= http_build_query($filters) ? '&' . http_build_query($filters) : '' ?>" 
                   class="btn btn-secondary" style="padding: 0.75rem 1.5rem; border-radius: 10px;">
                    Sau →
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Popular Categories -->
<div class="container" style="margin: 3rem auto;">
    <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; text-align: center; margin-bottom: 0.5rem;">
        Danh mục ngành nghề
    </h2>
    <p style="text-align: center; color: #6B7280; font-size: 0.95rem; margin-bottom: 2.5rem;">
        Tìm việc làm theo lĩnh vực bạn quan tâm
    </p>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem;">
        <!-- IT - Phần mềm -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #EEF2FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #6366F1;">💻</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">IT - Phần mềm</div>
            <div style="font-size: 0.875rem; color: #6B7280;">1250 việc làm</div>
        </div>
        
        <!-- Marketing -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #DCFCE7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #16A34A;">📢</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Marketing</div>
            <div style="font-size: 0.875rem; color: #6B7280;">850 việc làm</div>
        </div>
        
        <!-- Kinh doanh -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #CA8A04;">📊</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Kinh doanh</div>
            <div style="font-size: 0.875rem; color: #6B7280;">720 việc làm</div>
        </div>
        
        <!-- Thiết kế -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #FCE7F3; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #DB2777;">🎨</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Thiết kế</div>
            <div style="font-size: 0.875rem; color: #6B7280;">540 việc làm</div>
        </div>
        
        <!-- Nhân sự -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #E0E7FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #4F46E5;">👥</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Nhân sự</div>
            <div style="font-size: 0.875rem; color: #6B7280;">430 việc làm</div>
        </div>
        
        <!-- Kế toán -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #FEE2E2; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #DC2626;">🧮</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Kế toán</div>
            <div style="font-size: 0.875rem; color: #6B7280;">380 việc làm</div>
        </div>
        
        <!-- Giáo dục -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #DBEAFE; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #0284C7;">🎓</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Giáo dục</div>
            <div style="font-size: 0.875rem; color: #6B7280;">320 việc làm</div>
        </div>
        
        <!-- Y tế -->
        <div style="background: white; padding: 1.75rem; border-radius: 12px; border: 1px solid #E5E7EB; text-align: center; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.08)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="width: 64px; height: 64px; background: #D1FAE5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem;">
                <span style="color: #059669;">🏥</span>
            </div>
            <div style="font-weight: 600; color: #111827; font-size: 1rem; margin-bottom: 0.25rem;">Y tế</div>
            <div style="font-size: 0.875rem; color: #6B7280;">290 việc làm</div>
        </div>
    </div>
</div>

<!-- How It Works -->
<div style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); padding: 4rem 0; margin: 3rem 0;">
    <div class="container">
        <h2 style="font-size: 1.875rem; font-weight: 700; color: white; text-align: center; margin-bottom: 0.5rem;">
            Cách thức hoạt động
        </h2>
        <p style="text-align: center; color: rgba(255,255,255,0.9); font-size: 0.95rem; margin-bottom: 3rem;">
            Chỉ với 3 bước đơn giản
        </p>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 3rem; max-width: 900px; margin: 0 auto;">
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.25rem; backdrop-filter: blur(10px);">
                    <span style="font-size: 2rem;">👤</span>
                </div>
                <h3 style="font-weight: 700; color: white; margin-bottom: 0.75rem; font-size: 1.125rem;">1. Đăng ký tài khoản</h3>
                <p style="color: rgba(255,255,255,0.85); font-size: 0.9rem; line-height: 1.6;">Tạo tài khoản miễn phí và hoàn thiện hồ sơ của bạn</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.25rem; backdrop-filter: blur(10px);">
                    <span style="font-size: 2rem;">🔍</span>
                </div>
                <h3 style="font-weight: 700; color: white; margin-bottom: 0.75rem; font-size: 1.125rem;">2. Tìm việc phù hợp</h3>
                <p style="color: rgba(255,255,255,0.85); font-size: 0.9rem; line-height: 1.6;">Khám phá hàng nghìn công việc phù hợp với kỹ năng của bạn</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.25rem; backdrop-filter: blur(10px);">
                    <span style="font-size: 2rem;">✈️</span>
                </div>
                <h3 style="font-weight: 700; color: white; margin-bottom: 0.75rem; font-size: 1.125rem;">3. Ứng tuyển ngay</h3>
                <p style="color: rgba(255,255,255,0.85); font-size: 0.9rem; line-height: 1.6;">Gửi hồ sơ và nhận phản hồi từ nhà tuyển dụng</p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="<?= BASE_URL ?>/register" style="display: inline-block; background: white; color: #667EEA; padding: 0.875rem 2.5rem; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.2)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';">
                Bắt đầu ngay →
            </a>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/layouts/footer.php'; ?>
