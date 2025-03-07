<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

/**
 * دریافت شماره تلفن کاربر
 */
function music_panel_get_user_phone($user_id) {
    $phone = get_user_meta($user_id, 'phone_number', true);
    if (empty($phone)) {
        // اگر شماره تلفن در متادیتا نباشد، از فیلد دیگری استفاده کنید یا مقدار پیش‌فرض برگردانید
        return '';
    }
    return $phone;
}

/**
 * دریافت URL تصویر پروفایل کاربر
 */
function music_panel_get_profile_image_url($user_id, $size = 'thumbnail') {
    $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
    
    if (!empty($profile_image_id)) {
        $image = wp_get_attachment_image_src($profile_image_id, $size);
        if ($image) {
            return $image[0];
        }
    }
    
    // اگر تصویر پروفایل در متادیتا نباشد، از آواتار وردپرس استفاده کنید
    return get_avatar_url($user_id, array('size' => 96));
}