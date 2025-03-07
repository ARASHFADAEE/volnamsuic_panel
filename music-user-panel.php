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

// بارگذاری فایل‌های مورد نیاز
require_once MUSIC_PANEL_PATH . 'includes/class-music-panel-core.php';

// راه‌اندازی پلاگین
function music_panel_init() {
    $music_panel = new Music_Panel_Core();
    $music_panel->init();
}
add_action('plugins_loaded', 'music_panel_init');

// فعال‌سازی پلاگین
register_activation_hook(__FILE__, 'music_panel_activate');
function music_panel_activate() {
    // افزودن endpoint ها و flush کردن rewrite rules
    music_panel_endpoints();
    flush_rewrite_rules();
}

// غیرفعال‌سازی پلاگین
register_deactivation_hook(__FILE__, 'music_panel_deactivate');
function music_panel_deactivate() {
    flush_rewrite_rules();
}