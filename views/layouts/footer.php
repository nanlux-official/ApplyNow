    </main>
    
    <!-- Footer -->
    <footer style="background: linear-gradient(to bottom, #F9FAFB 0%, #F3F4F6 100%); border-top: 1px solid #E5E7EB; margin-top: 4rem;">
        <div class="container" style="padding: 3rem 1.5rem 1.5rem;">
            <!-- Main Footer Content -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 3rem; margin-bottom: 3rem;">
                <!-- Company Info -->
                <div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1F2937; margin-bottom: 1rem;">
                        Job Portal
                    </h3>
                    <p style="color: #6B7280; line-height: 1.8; margin-bottom: 1.5rem;">
                        Nền tảng tìm kiếm việc làm hàng đầu Việt Nam, kết nối hàng nghìn ứng viên với các cơ hội nghề nghiệp tốt nhất.
                    </p>
                    
                    <!-- Social Media -->
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: white; display: flex; align-items: center; justify-content: center; color: #3B82F6; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: white; display: flex; align-items: center; justify-content: center; color: #3B82F6; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: white; display: flex; align-items: center; justify-content: center; color: #3B82F6; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 8px; background: white; display: flex; align-items: center; justify-content: center; color: #3B82F6; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <!-- For Candidates -->
                <div>
                    <h4 style="font-size: 1rem; font-weight: 600; color: #1F2937; margin-bottom: 1.25rem;">Ứng viên</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li>
                            <a href="<?= BASE_URL ?>/jobs" style="color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#6B7280'">
                                <i class="fas fa-search" style="font-size: 0.875rem;"></i>
                                Tìm việc làm
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/register" style="color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#6B7280'">
                                <i class="fas fa-user-plus" style="font-size: 0.875rem;"></i>
                                Đăng ký
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/support" style="color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#6B7280'">
                                <i class="fas fa-headset" style="font-size: 0.875rem;"></i>
                                Hỗ trợ
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- For Employers -->
                <div>
                    <h4 style="font-size: 1rem; font-weight: 600; color: #1F2937; margin-bottom: 1.25rem;">Nhà tuyển dụng</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li>
                            <a href="<?= BASE_URL ?>/register" style="color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#6B7280'">
                                <i class="fas fa-briefcase" style="font-size: 0.875rem;"></i>
                                Đăng tin
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/login" style="color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#6B7280'">
                                <i class="fas fa-sign-in-alt" style="font-size: 0.875rem;"></i>
                                Đăng nhập
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/support" style="color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#6B7280'">
                                <i class="fas fa-headset" style="font-size: 0.875rem;"></i>
                                Hỗ trợ
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 style="font-size: 1rem; font-weight: 600; color: #1F2937; margin-bottom: 1.25rem;">Liên hệ</h4>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-envelope" style="color: #3B82F6; font-size: 0.875rem;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.25rem;">Email</div>
                                <a href="mailto:contact@jobportal.com" style="color: #1F2937; text-decoration: none; font-weight: 500;">contact@jobportal.com</a>
                            </div>
                        </div>
                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-phone" style="color: #3B82F6; font-size: 0.875rem;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.25rem;">Hotline</div>
                                <a href="tel:1900xxxx" style="color: #1F2937; text-decoration: none; font-weight: 500;">1900 xxxx</a>
                            </div>
                        </div>
                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-map-marker-alt" style="color: #3B82F6; font-size: 0.875rem;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.25rem;">Địa chỉ</div>
                                <div style="color: #1F2937; font-weight: 500;">Hà Nội, Việt Nam</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div style="border-top: 1px solid #E5E7EB; padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <p style="color: #6B7280; margin: 0; font-size: 0.875rem;">
                    &copy; 2024 Job Portal. All rights reserved.
                </p>
                <p style="color: #6B7280; margin: 0; font-size: 0.875rem;">
                    Made with NanLux
                </p>
            </div>
        </div>
    </footer>
    
    <script src="<?= ASSETS_URL ?>/js/main.js"></script>
</body>
</html>
