<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

/**
 * نمایش پیام‌های خطا یا موفقیت
 */
function music_panel_show_messages() {
    if (!session_id()) {
        session_start();
    }
    
    $output = '';
    
    if (isset($_SESSION['profile_error'])) {
        $output .= '<div class="alert alert-danger">' . esc_html($_SESSION['profile_error']) . '</div>';
        unset($_SESSION['profile_error']);
    }
    
    if (isset($_SESSION['profile_success'])) {
        $output .= '<div class="alert alert-success">' . esc_html($_SESSION['profile_success']) . '</div>';
        unset($_SESSION['profile_success']);
    }
    
    return $output;
}

/**
 * دریافت تاریخ شمسی
 */
function music_panel_get_jalali_date() {
    if (function_exists('jdate')) {
        return jdate('l Y/m/d');
    }
    return date('Y/m/d');
}

/**
 * پاسخ خطا برای AJAX در صورت لاگین نبودن
 */
function music_panel_ajax_login_required() {
    wp_send_json_error('لطفا وارد حساب کاربری خود شوید.');
    exit;
}