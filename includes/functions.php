<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

/**
 * افزودن endpoint ها به وردپرس
 */
function music_panel_add_endpoints() {
    add_rewrite_endpoint('user-panel', EP_ROOT);
    add_rewrite_endpoint('saved-music', EP_ROOT);
    add_rewrite_endpoint('profile', EP_ROOT);
}
add_action('init', 'music_panel_add_endpoints');

/**
 * مدیریت endpoint ها و لود کردن قالب‌های مناسب
 */
function music_panel_template_redirect() {
    global $wp_query;
    
    // بررسی endpoint های مختلف
    if (isset($wp_query->query_vars['user-panel'])) {
        music_panel_check_login();
        include(MUSIC_PANEL_PATH . 'templates/dashboard.php');
        exit;
    }
    
    if (isset($wp_query->query_vars['saved-music'])) {
        music_panel_check_login();
        include(MUSIC_PANEL_PATH . 'templates/saved-music.php');
        exit;
    }
    
    if (isset($wp_query->query_vars['profile'])) {
        music_panel_check_login();
        include(MUSIC_PANEL_PATH . 'templates/profile.php');
        exit;
    }
}
add_action('template_redirect', 'music_panel_template_redirect');