<?php
/**
 * Plugin Name: Music User Panel
 * Description: پنل کاربری برای سایت موزیک
 * Version: 1.0.0
 * Author: نام شما
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

// تعریف ثابت‌های پلاگین
define('MUSIC_PANEL_VERSION', '1.0.0');
define('MUSIC_PANEL_PATH', plugin_dir_path(__FILE__));
define('MUSIC_PANEL_URL', plugin_dir_url(__FILE__));

// لود کردن فایل‌های مورد نیاز
require_once MUSIC_PANEL_PATH . 'includes/functions.php';
require_once MUSIC_PANEL_PATH . 'includes/class-music-panel-profile.php';
require_once MUSIC_PANEL_PATH . 'includes/saved-music-functions.php';

// فعال‌سازی پلاگین
register_activation_hook(__FILE__, 'music_panel_activate');
function music_panel_activate() {
    // ایجاد دایرکتوری‌ها
    music_panel_create_folders();
    
    // افزودن endpoint ها
    music_panel_add_endpoints();
    flush_rewrite_rules();
    
    // ایجاد جدول موزیک‌های ذخیره شده
    if (function_exists('music_panel_create_saved_music_table')) {
        music_panel_create_saved_music_table();
    }
}

// ایجاد پوشه‌های مورد نیاز
function music_panel_create_folders() {
    $directories = array(
        MUSIC_PANEL_PATH . 'assets/css',
        MUSIC_PANEL_PATH . 'assets/js',
        MUSIC_PANEL_PATH . 'assets/icons',
        MUSIC_PANEL_PATH . 'templates',
        MUSIC_PANEL_PATH . 'includes',
    );
    
    foreach ($directories as $dir) {
        if (!file_exists($dir)) {
            wp_mkdir_p($dir);
        }
    }
}

// غیرفعال‌سازی پلاگین
register_deactivation_hook(__FILE__, 'music_panel_deactivate');
function music_panel_deactivate() {
    flush_rewrite_rules();
}

// افزودن endpoint ها به وردپرس
function music_panel_add_endpoints() {
    add_rewrite_endpoint('user-panel', EP_ROOT);
    add_rewrite_endpoint('saved-music', EP_ROOT);
    add_rewrite_endpoint('profile', EP_ROOT);
}
add_action('init', 'music_panel_add_endpoints');

// مدیریت endpoint ها و لود کردن قالب‌های مناسب
function music_panel_template_redirect() {
    global $wp_query;
    
    // بررسی endpoint های مختلف
    if (isset($wp_query->query_vars['user-panel'])) {
        // بررسی لاگین بودن کاربر
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(home_url('user-panel')));
            exit;
        }
        
        include(MUSIC_PANEL_PATH . 'templates/dashboard.php');
        exit;
    }
    
    if (isset($wp_query->query_vars['saved-music'])) {
        // بررسی لاگین بودن کاربر
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(home_url('saved-music')));
            exit;
        }
        
        include(MUSIC_PANEL_PATH . 'templates/saved-music.php');
        exit;
    }
    
    if (isset($wp_query->query_vars['profile'])) {
        // بررسی لاگین بودن کاربر
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(home_url('profile')));
            exit;
        }
        
        include(MUSIC_PANEL_PATH . 'templates/profile.php');
        exit;
    }
}
add_action('template_redirect', 'music_panel_template_redirect');

// اضافه کردن CSS و JS
function music_panel_enqueue_scripts() {
    // بوت‌استرپ
    wp_enqueue_style('bootstrap-rtl', MUSIC_PANEL_URL . 'assets/css/bootstrap.rtl.min.css', array(), '5.3.0');
    wp_enqueue_script('bootstrap-js', MUSIC_PANEL_URL . 'assets/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    wp_enqueue_style('style-css-panel', MUSIC_PANEL_URL . 'assets/css/style.css', array(), '5.3.0');

    // استایل‌های سفارشی
    wp_enqueue_script('music-panel-js', MUSIC_PANEL_URL . 'assets/js/music-panel.js', array('jquery'), MUSIC_PANEL_VERSION, true);
    
    // اضافه کردن متغیرهای ajax
    wp_localize_script('music-panel-js', 'music_panel', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('music_panel_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'music_panel_enqueue_scripts');