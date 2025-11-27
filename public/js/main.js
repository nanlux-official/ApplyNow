// Main JavaScript file

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Set active menu item
    setActiveMenu();
});

// Set active menu based on current URL
function setActiveMenu() {
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.nav-menu a:not(.btn-primary)');
    
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (!href) return;
        
        // Extract path from href
        const linkPath = href.replace(/^https?:\/\/[^\/]+/, '');
        
        // Check if current path contains the link path
        if (currentPath.includes(linkPath) && linkPath !== '/') {
            link.classList.add('active');
        } else if (currentPath === '/' && linkPath === '/') {
            link.classList.add('active');
        }
    });
}

// AJAX helper function
function ajax(url, method = 'GET', data = null) {
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: data ? JSON.stringify(data) : null
    }).then(response => response.json());
}

// Confirm before delete
function confirmDelete(message = 'Bạn có chắc chắn muốn xóa?') {
    return confirm(message);
}

// Format number as currency
function formatMoney(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Show loading spinner
function showLoading() {
    const loader = document.createElement('div');
    loader.id = 'loading-spinner';
    loader.innerHTML = '<div class="spinner"></div>';
    document.body.appendChild(loader);
}

function hideLoading() {
    const loader = document.getElementById('loading-spinner');
    if (loader) {
        loader.remove();
    }
}

// Form validation helper
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            isValid = false;
        } else {
            input.classList.remove('error');
        }
    });
    
    return isValid;
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.insertBefore(notification, mainContent.firstChild);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
}
