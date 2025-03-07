<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

class Music_Panel_Core {
    
    public function init() {
        // بارگذاری کلاس‌های مورد نیاز
        $this->load_dependencies();
        
        // اضافه کردن endpoint ها
        add_action('init', array($this, 'add_endpoints'));
        
        // تغییر مسیر template
        add_action('template_redirect', array($this, 'handle_endpoints'));
        
        // اضافه کردن assets
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // اضافه کردن shortcode برای نمایش پنل
        add_shortcode('music_user_panel', array($this, 'panel_shortcode'));
    }
    
    private function load_dependencies() {
        require_once MUSIC_PANEL_PATH . 'includes/class-music-panel-ajax.php';
        require_once MUSIC_PANEL_PATH . 'includes/class-music-panel-saved-music.php';
        require_once MUSIC_PANEL_PATH . 'includes/class-music-panel-user.php';
        require_once MUSIC_PANEL_PATH . 'includes/class-music-panel-profile.php'; // اضافه کردن کلاس پروفایل
        
        // راه‌اندازی کلاس‌ها
        new Music_Panel_Ajax();
        new Music_Panel_Saved_Music();
        // new Music_Panel_User();
        new Music_Panel_Profile(); // راه‌اندازی کلاس پروفایل
    }
    
    public function add_endpoints() {
        add_rewrite_endpoint('user-panel', EP_ROOT);
        add_rewrite_endpoint('saved-music', EP_ROOT);
        add_rewrite_endpoint('profile', EP_ROOT);
    }
    
    public function handle_endpoints() {
        global $wp_query;
        
        // بررسی لاگین بودن کاربر
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(home_url('user-panel')));
            exit;
        }
        
        if (isset($wp_query->query_vars['user-panel'])) {
            include(MUSIC_PANEL_PATH . 'templates/dashboard.php');
            exit;
        }
        
        if (isset($wp_query->query_vars['saved-music'])) {
            include(MUSIC_PANEL_PATH . 'templates/saved-music.php');
            exit;
        }
        
        if (isset($wp_query->query_vars['profile'])) {
            include(MUSIC_PANEL_PATH . 'templates/profile.php');
            exit;
        }
    }
    
    public function enqueue_scripts() {
        // اضافه کردن فایل‌های CSS و JS
        wp_enqueue_style('music-panel-bootstrap-css', MUSIC_PANEL_URL . 'css/bootstrap.rtl.min.css', array(), MUSIC_PANEL_VERSION);
        wp_enqueue_style('music-panel-normalize-css', MUSIC_PANEL_URL . 'css/normalize.css', array(), MUSIC_PANEL_VERSION);
        wp_enqueue_style('music-panel-style-css', MUSIC_PANEL_URL . 'css/style.css', array(), MUSIC_PANEL_VERSION);

        wp_enqueue_script('music-panel-js', MUSIC_PANEL_URL . '/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MUSIC_PANEL_VERSION, true);
            // اضافه کردن فایل اعتبارسنجی پروفایل
    if (isset($GLOBALS['wp_query']->query_vars['profile'])) {
        wp_enqueue_script('profile-validation-js', MUSIC_PANEL_URL . 'assets/js/profile-validation.js', array('jquery'), MUSIC_PANEL_VERSION, true);
    }
        
        // اضافه کردن متغیرهای ajax
        wp_localize_script('music-panel-js', 'music_panel', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('music_panel_nonce')
        ));
    }
    
    public function panel_shortcode($atts) {
        ob_start();
        
        if (!is_user_logged_in()) {
            echo '<div class="music-panel-login">';
            echo '<p>برای دسترسی به پنل کاربری، لطفا وارد شوید.</p>';
            echo '<a href="' . wp_login_url(get_permalink()) . '" class="button">ورود</a>';
            echo '</div>';
        } else {
            include(MUSIC_PANEL_PATH . 'templates/dashboard.php');
        }
        
        return ob_get_clean();
    }
}