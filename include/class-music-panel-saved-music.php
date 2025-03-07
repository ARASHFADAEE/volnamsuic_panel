<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

class Music_Panel_Saved_Music {
    
    public function __construct() {
        // ایجاد جدول در صورت نیاز
        $this->create_table();
    }
    
    private function create_table() {
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
    
    public function add_music($user_id, $music_id) {
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
    
    public function remove_music($user_id, $music_id) {
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
    
    public function get_user_music($user_id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'user_saved_music';
        
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT music_id FROM $table_name WHERE user_id = %d ORDER BY date_added DESC",
            $user_id
        ), ARRAY_A);
        
        return $results;
    }
}