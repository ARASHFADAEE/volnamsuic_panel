<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

/**
 * دریافت تصویر پروفایل کاربر
 */
function music_panel_get_profile_image_url($user_id, $size = 'thumbnail') {
    $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
    
    if ($profile_image_id) {
        return wp_get_attachment_image_url($profile_image_id, $size);
    }
    
    // برگرداندن آواتار پیش‌فرض وردپرس
    return get_avatar_url($user_id, array('size' => 150));
}

/**
 * دریافت شماره تلفن کاربر
 */
function music_panel_get_user_phone($user_id) {
    return get_user_meta($user_id, 'phone_number', true);
}

/**
 * پردازش فرم ویرایش پروفایل
 */
function music_panel_process_profile_update() {
    // بررسی nonce برای امنیت
    if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], 'update_user_profile')) {
        wp_die('خطای امنیتی رخ داده است. لطفا دوباره تلاش کنید.', 'خطای امنیتی', array('back_link' => true));
    }
    
    // بررسی لاگین بودن کاربر
    if (!is_user_logged_in()) {
        wp_redirect(wp_login_url(home_url('profile')));
        exit;
    }
    
    $user_id = get_current_user_id();
    $error = false;
    $success_message = 'اطلاعات پروفایل با موفقیت بروزرسانی شد.';
    $error_message = '';
    
    // دریافت و تمیز کردن داده‌ها
    $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $old_password = isset($_POST['old_password']) ? $_POST['old_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    
    // بروزرسانی نام و نام خانوادگی
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    
    // بروزرسانی شماره تلفن (متا فیلد سفارشی)
    update_user_meta($user_id, 'phone_number', $phone);
    
    // بروزرسانی ایمیل
    if (!empty($email) && is_email($email)) {
        $current_user = get_user_by('id', $user_id);
        if ($current_user->user_email !== $email) {
            // بررسی تکراری نبودن ایمیل
            if (!email_exists($email)) {
                $args = array(
                    'ID' => $user_id,
                    'user_email' => $email
                );
                wp_update_user($args);
            } else {
                $error = true;
                $error_message .= 'ایمیل وارد شده قبلا ثبت شده است. ';
            }
        }
    } else if (!empty($email)) {
        $error = true;
        $error_message .= 'ایمیل وارد شده معتبر نیست. ';
    }
    
    // بروزرسانی رمز عبور
    if (!empty($new_password)) {
        if (empty($old_password)) {
            $error = true;
            $error_message .= 'برای تغییر رمز عبور، وارد کردن رمز عبور فعلی الزامی است. ';
        } else {
            $user = get_user_by('id', $user_id);
            if ($user && wp_check_password($old_password, $user->data->user_pass, $user_id)) {
                wp_set_password($new_password, $user_id);
                
                // لاگین مجدد کاربر
                $creds = array(
                    'user_login' => $user->data->user_login,
                    'user_password' => $new_password,
                    'remember' => true
                );
                wp_signon($creds, false);
                
                $success_message .= ' رمز عبور با موفقیت تغییر کرد.';
            } else {
                $error = true;
                $error_message .= 'رمز عبور فعلی اشتباه است. ';
            }
        }
    }
    
    // ذخیره پیام‌ها در session
    if (!session_id()) {
        session_start();
    }
    
    if ($error) {
        $_SESSION['profile_error'] = $error_message;
    } else {
        $_SESSION['profile_success'] = $success_message;
    }
    
    // ریدایرکت به صفحه پروفایل
    wp_redirect(home_url('profile'));
    exit;
}
add_action('admin_post_update_user_profile', 'music_panel_process_profile_update');
add_action('admin_post_nopriv_update_user_profile', 'music_panel_redirect_to_login');

/**
 * ریدایرکت به صفحه لاگین
 */
function music_panel_redirect_to_login() {
    wp_redirect(wp_login_url(home_url('profile')));
    exit;
}

/**
 * پردازش آپلود تصویر پروفایل با AJAX
 */
function music_panel_process_profile_image_upload() {
    // بررسی nonce برای امنیت
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'profile_image_upload')) {
        wp_send_json_error('خطای امنیتی رخ داده است.');
        exit;
    }
    
    // بررسی لاگین بودن کاربر
    if (!is_user_logged_in()) {
        wp_send_json_error('لطفا وارد حساب کاربری خود شوید.');
        exit;
    }
    
    $user_id = get_current_user_id();
    
    // بررسی آپلود فایل
    if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('خطا در آپلود فایل.');
        exit;
    }
    
    // بررسی نوع فایل
    $allowed_types = array('image/jpeg', 'image/png', 'image/jpg');
    if (!in_array($_FILES['profile_image']['type'], $allowed_types)) {
        wp_send_json_error('فرمت فایل باید JPG یا PNG باشد.');
        exit;
    }
    
    // بررسی حجم فایل (حداکثر 2MB)
    if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
        wp_send_json_error('حجم فایل باید کمتر از 2 مگابایت باشد.');
        exit;
    }
    
    // آپلود فایل با استفاده از کتابخانه وردپرس
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    
    // آپلود فایل و دریافت آیدی آن
    $attachment_id = media_handle_upload('profile_image', 0);
    
    if (is_wp_error($attachment_id)) {
        wp_send_json_error($attachment_id->get_error_message());
        exit;
    }
    
    // ذخیره آیدی تصویر در متادیتای کاربر
    update_user_meta($user_id, 'profile_image_id', $attachment_id);
    
    // دریافت URL تصویر
    $image_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
    
    wp_send_json_success(array(
        'message' => 'تصویر پروفایل با موفقیت بروزرسانی شد.',
        'image_url' => $image_url
    ));
    exit;
}
add_action('wp_ajax_upload_profile_image', 'music_panel_process_profile_image_upload');
add_action('wp_ajax_nopriv_upload_profile_image', 'music_panel_ajax_login_required');

/**
 * پاسخ خطا برای AJAX در صورت لاگین نبودن
 */
function music_panel_ajax_login_required() {
    wp_send_json_error('لطفا وارد حساب کاربری خود شوید.');
    exit;
}