// assets/js/profile-validation.js
jQuery(document).ready(function($) {
    // اعتبارسنجی فرم پروفایل
    $('#profile-form').on('submit', function(e) {
        let isValid = true;
        let errorMessage = '';
        
        // بررسی ایمیل
        const email = $('#email').val();
        if (email && !isValidEmail(email)) {
            isValid = false;
            errorMessage += 'ایمیل وارد شده معتبر نیست. ';
            $('#email').addClass('is-invalid');
        } else {
            $('#email').removeClass('is-invalid');
        }
        
        // بررسی شماره تلفن
        const phone = $('#phone').val();
        if (phone && !isValidPhone(phone)) {
            isValid = false;
            errorMessage += 'شماره تلفن وارد شده معتبر نیست. ';
            $('#phone').addClass('is-invalid');
        } else {
            $('#phone').removeClass('is-invalid');
        }
        
        // بررسی رمز عبور
        const oldPassword = $('#old_password').val();
        const newPassword = $('#new_password').val();
        
        if (newPassword && !oldPassword) {
            isValid = false;
            errorMessage += 'برای تغییر رمز عبور، وارد کردن رمز عبور فعلی الزامی است. ';
            $('#old_password').addClass('is-invalid');
        } else {
            $('#old_password').removeClass('is-invalid');
        }
        
        if (newPassword && newPassword.length < 6) {
            isValid = false;
            errorMessage += 'رمز عبور جدید باید حداقل 6 کاراکتر باشد. ';
            $('#new_password').addClass('is-invalid');
        } else {
            $('#new_password').removeClass('is-invalid');
        }
        
        // نمایش پیام خطا
        if (!isValid) {
            e.preventDefault();
            
            // نمایش پیام خطا
            if ($('#validation-error').length === 0) {
                $('<div id="validation-error" class="alert alert-danger mx-4 mb-3"></div>').insertBefore('#profile-form');
            }
            $('#validation-error').text(errorMessage);
            
            // اسکرول به بالای فرم
            $('html, body').animate({
                scrollTop: $('#validation-error').offset().top - 100
            }, 300);
        }
    });
    
    // تابع بررسی اعتبار ایمیل
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    // تابع بررسی اعتبار شماره تلفن (فرمت ایران)
    function isValidPhone(phone) {
        // حذف فاصله‌ها و کاراکترهای اضافی
        phone = phone.replace(/\s+/g, '').replace(/-/g, '');
        
        // بررسی فرمت شماره موبایل ایران
        const regex = /^(0|98|\+98)9\d{9}$/;
        return regex.test(phone);
    }
    
    // فرمت کردن شماره تلفن هنگام تایپ
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 4) {
                $(this).val(value);
            } else if (value.length <= 7) {
                $(this).val(value.substring(0, 4) + ' ' + value.substring(4));
            } else {
                $(this).val(value.substring(0, 4) + ' ' + value.substring(4, 7) + ' ' + value.substring(7, 11));
            }
        }
    });
});