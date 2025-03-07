<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ایجاد جدول موزیک‌های ذخیره شده
 */
function music_panel_create_saved_music_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'user_saved_music';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            music_id bigint(20) NOT NULL,
            date_added datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY user_music (user_id, music_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/**
 * ذخیره موزیک برای کاربر
 */
function music_panel_add_saved_music($user_id, $music_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'user_saved_music';
    
    // بررسی تکراری نبودن
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND music_id = %d",
        $user_id, $music_id
    ));
    
    if ($exists) {
        return true; // قبلا ذخیره شده است
    }
    
    // افزودن رکورد جدید
    $result = $wpdb->insert(
        $table_name,
        array(
            'user_id' => $user_id,
            'music_id' => $music_id
        ),
        array('%d', '%d')
    );
    
    return $result !== false;
}

/**
 * حذف موزیک ذخیره شده کاربر
 */
function music_panel_remove_saved_music($user_id, $music_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'user_saved_music';
    
    $result = $wpdb->delete(
        $table_name,
        array(
            'user_id' => $user_id,
            'music_id' => $music_id
        ),
        array('%d', '%d')
    );
    
    return $result !== false;
}

/**
 * دریافت لیست موزیک‌های ذخیره شده کاربر
 */
function music_panel_get_user_saved_music($user_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'user_saved_music';
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT music_id FROM $table_name WHERE user_id = %d ORDER BY date_added DESC",
        $user_id
    ), ARRAY_A);
    
    return $results;
}

/**
 * بررسی ذخیره شدن موزیک توسط کاربر
 */
function music_panel_is_music_saved($user_id, $music_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'user_saved_music';
    
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND music_id = %d",
        $user_id, $music_id
    ));
    
    return $exists > 0;
}

/**
 * ذخیره موزیک با AJAX
 */
function music_panel_ajax_save_music() {
    // بررسی nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'music_panel_nonce')) {
        wp_send_json_error('خطای امنیتی');
    }
    
    // بررسی لاگین بودن کاربر
    if (!is_user_logged_in()) {
        wp_send_json_error('لطفا وارد حساب کاربری خود شوید');
    }
    
    // دریافت اطلاعات موزیک
    $music_id = isset($_POST['music_id']) ? intval($_POST['music_id']) : 0;
    
    if (!$music_id) {
        wp_send_json_error('آیدی موزیک نامعتبر است');
    }
    
    // ذخیره موزیک برای کاربر
    $result = music_panel_add_saved_music(get_current_user_id(), $music_id);
    
    if ($result) {
        wp_send_json_success('موزیک با موفقیت ذخیره شد');
    } else {
        wp_send_json_error('خطا در ذخیره موزیک');
    }
}
add_action('wp_ajax_save_music', 'music_panel_ajax_save_music');
add_action('wp_ajax_nopriv_save_music', 'music_panel_ajax_login_required');

/**
 * حذف موزیک با AJAX
 */
function music_panel_ajax_remove_music() {
    // بررسی nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'music_panel_nonce')) {
        wp_send_json_error('خطای امنیتی');
    }
    
    // بررسی لاگین بودن کاربر
    if (!is_user_logged_in()) {
        wp_send_json_error('لطفا وارد حساب کاربری خود شوید');
    }
    
    // دریافت اطلاعات موزیک
    $music_id = isset($_POST['music_id']) ? intval($_POST['music_id']) : 0;
    
    if (!$music_id) {
        wp_send_json_error('آیدی موزیک نامعتبر است');
    }
    
    // حذف موزیک برای کاربر
    $result = music_panel_remove_saved_music(get_current_user_id(), $music_id);
    
    if ($result) {
        wp_send_json_success('موزیک با موفقیت حذف شد');
    } else {
        wp_send_json_error('خطا در حذف موزیک');
    }
}
add_action('wp_ajax_remove_music', 'music_panel_ajax_remove_music');
add_action('wp_ajax_nopriv_remove_music', 'music_panel_ajax_login_required');