<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

class Music_Panel_Ajax {
    
    public function __construct() {
        // ثبت اکشن‌های ajax
        add_action('wp_ajax_save_music', array($this, 'save_music'));
        add_action('wp_ajax_remove_music', array($this, 'remove_music'));
        add_action('wp_ajax_update_profile', array($this, 'update_profile'));
    }
    
    public function save_music() {
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
        $saved_music = new Music_Panel_Saved_Music();
        $result = $saved_music->add_music(get_current_user_id(), $music_id);
        
        if ($result) {
            wp_send_json_success('موزیک با موفقیت ذخیره شد');
        } else {
            wp_send_json_error('خطا در ذخیره موزیک');
        }
    }
    
    public function remove_music() {
        // مشابه با save_music با تغییرات لازم
    }
    
    public function update_profile() {
        // بررسی nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'music_panel_nonce')) {
            wp_send_json_error('خطای امنیتی');
        }
        
        // بررسی لاگین بودن کاربر
        if (!is_user_logged_in()) {
            wp_send_json_error('لطفا وارد حساب کاربری خود شوید');
        }
        
        // دریافت اطلاعات کاربر
        $user_data = array(
            'ID' => get_current_user_id(),
            'display_name' => isset($_POST['display_name']) ? sanitize_text_field($_POST['display_name']) : '',
            'user_email' => isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : ''
        );
        
        // بروزرسانی اطلاعات کاربر
        $user_id = wp_update_user($user_data);
        
        if (is_wp_error($user_id)) {
            wp_send_json_error($user_id->get_error_message());
        } else {
            wp_send_json_success('اطلاعات کاربری با موفقیت بروزرسانی شد');
        }
    }
}