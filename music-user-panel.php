<?php
/**
 * Plugin Name: پنل موزیک ولنا
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
require_once MUSIC_PANEL_PATH . 'includes/endpoints.php';
require_once MUSIC_PANEL_PATH . 'includes/profile-functions.php';
require_once MUSIC_PANEL_PATH . 'includes/saved-music-functions.php';

// // اضافه کردن CSS و JS
// function music_panel_enqueue_scripts() {
//         // اضافه کردن فایل‌های CSS و JS
//         wp_enqueue_style('music-panel-bootstrap-css', MUSIC_PANEL_URL . 'css/bootstrap.rtl.min.css', array(), MUSIC_PANEL_VERSION);
//         wp_enqueue_style('music-panel-normalize-css', MUSIC_PANEL_URL . 'css/normalize.css', array(), MUSIC_PANEL_VERSION);
//         wp_enqueue_style('music-panel-style-css', MUSIC_PANEL_URL . 'css/style.css', array(), MUSIC_PANEL_VERSION);
//         wp_enqueue_script('music-panel-js', MUSIC_PANEL_URL . 'assets/js/music-panel.js', array('jquery'), MUSIC_PANEL_VERSION, true);
//         wp_enqueue_script('music-panel-bootstrap', MUSIC_PANEL_URL . '/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MUSIC_PANEL_VERSION, true);
    
//     // اضافه کردن متغیرهای ajax
//     wp_localize_script('music-panel-js', 'music_panel', array(
//         'ajax_url' => admin_url('admin-ajax.php'),
//         'nonce' => wp_create_nonce('music_panel_nonce')
//     ));
// }
// add_action('wp_enqueue_scripts', 'music_panel_enqueue_scripts');

// // فعال‌سازی پلاگین
// register_activation_hook(__FILE__, 'music_panel_activate');
// function music_panel_activate() {
//     // ایجاد جدول موزیک‌های ذخیره شده
//     music_panel_create_saved_music_table();
    
//     // افزودن endpoint ها
//     music_panel_add_endpoints();
//     flush_rewrite_rules();
    
//     // ایجاد فولدرهای مورد نیاز
//     music_panel_create_folders();
// }

// // غیرفعال‌سازی پلاگین
// register_deactivation_hook(__FILE__, 'music_panel_deactivate');
// function music_panel_deactivate() {
//     flush_rewrite_rules();
// }

// ایجاد فولدرهای مورد نیاز اگر وجود ندارند
// function music_panel_create_folders() {
//     $directories = array(
//         MUSIC_PANEL_PATH . 'templates',
//         MUSIC_PANEL_PATH . 'assets/css',
//         MUSIC_PANEL_PATH . 'assets/js',
//         MUSIC_PANEL_PATH . 'assets/icons',
//     );
    
//     foreach ($directories as $dir) {
//         if (!file_exists($dir)) {
//             wp_mkdir_p($dir);
//         }
//     }
// }