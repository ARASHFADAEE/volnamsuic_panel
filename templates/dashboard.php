<?php
// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

// بررسی لاگین بودن کاربر
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(home_url('user-panel')));
    exit;
}

// دریافت اطلاعات کاربر
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// دریافت متادیتای کاربر
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$phone_number = music_panel_get_user_phone($user_id);
$profile_image_url = music_panel_get_profile_image_url($user_id, 'medium');

// تاریخ شمسی امروز
$jalali_date = '';
if (function_exists('jdate')) {
    $jalali_date = jdate('l Y/m/d');
} else {
    $jalali_date = date('Y/m/d');
}

// دریافت آخرین مقالات
$latest_posts = get_posts(array(
    'numberposts' => 6,
    'post_status' => 'publish'
));
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>داشبورد کاربری - <?php bloginfo('name'); ?></title>
    <link rel="icon" href="<?php echo MUSIC_PANEL_URL; ?>assets/icons/iran-ausbildung-icon.png" type="image/x-icon" />
    <?php wp_head(); ?>
</head>

<body>
    <div>
        <!-- main nav -->
        <aside class="position-fixed main-aside navbar d-none d-md-flex bg-c-black navbar-expand-md py-0 h-100">
        <!-- bottom nav -->
        <nav class="d-none d-md-flex flex-column w-100 px-0 h-100 text-white-400 bg-black-700">
            <div class="container-lg d-flex flex-column px-3 py-2">
                <!-- left -->
                <div>
                    <div class="d-flex align-items-center gap-2 justify-content-center pb-1 border-bottom border-2 border-gray-700">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/volna-music_logo.svg'); ?>" alt="" />
                    </div>
                    <ul class="navbar-nav gap-3 custom-font d-flex flex-column my-3">
                        <li class="main-aside-link nav-item active">
                            <a class="nav-link ps-3 text-white-400 fs-xs d-flex gap-2 align-items-center" aria-current="page" href="<?php echo home_url('user-panel'); ?>">
                                <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/dashboard-icon.svg" alt="" />
                                <span class="d-none d-xl-inline">داشبورد</span>
                            </a>
                        </li>
                        <li class="main-aside-link nav-item">
                            <a class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center" href="<?php echo home_url('saved-music'); ?>">
                                <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/save-no-fill.svg" alt="" />
                                <span class="d-none d-xl-inline">موزیک های ذخیره شده</span>
                            </a>
                        </li>
                        <li class="main-aside-link nav-item ">
                            <a class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center" href="<?php echo home_url('profile'); ?>">
                                <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/user-icon.svg" alt="" />
                                <span class="d-none d-xl-inline">ویرایش اطلاعات کاربری</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-auto pb-3 mb-md-0 mx-2 d-md-flex align-items-center">
                <a class="dir-ltr w-100 text-white d-flex justify-content-center align-content-center" href="tel:+984584587">
                    <span class="d-none d-xl-inline">021 - 4584587</span>
                    <img class="d-inline d-xl-none" src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/phone-icon.svg" alt="" />
                </a>
            </div>
        </nav>
    </aside>
        <section class="main-container h-100 d-flex flex-column flex-grow-1 bg-gray-50">
        <nav class="w-100">
            <div class="d-flex px-3 py-2 h-auto bg-black-700 bg-md-white justify-content-between align-items-center">
                <!-- user info -->
                <div class="d-none d-md-flex gap-2">
                    <figure>
                        <img class="user-img img-fluid rounded-circle border border-3" src="<?php echo esc_url($profile_image_url); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>" />
                    </figure>
                    <div class="d-flex flex-column justify-content-evenly">
                        <p class="fs-xs fw-medium"><?php echo esc_html($current_user->display_name); ?></p>
                        <p class="fs-xxs text-gray-400"><?php echo esc_html($phone_number); ?></p>
                    </div>
                </div>
                <button class="hamburger-icon bg-gray-700 d-flex align-items-center justify-content-center navbar-toggler d-block d-md-none shadow-none border-0 rounded-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <img class="navbar-toggler" src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/hamburger-icon.svg" />
                </button>
                <div class="offcanvas offcanvas-start w-75 bg-black-700" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header justify-content-between">
                        <!-- user info -->
                        <div class="d-flex gap-2">
                            <figure>
                                <img class="user-img img-fluid rounded-circle border border-3" src="<?php echo esc_url($profile_image_url); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>" />
                            </figure>
                            <div class="d-flex flex-column text-gray-400 justify-content-evenly">
                                <p class="fs-xs fw-medium"><?php echo esc_html($current_user->display_name); ?></p>
                                <p class="fs-xxs"><?php echo esc_html($phone_number); ?></p>
                            </div>
                        </div>
                        <button class="border-0 bg-gray-700 rounded-2 p-2 d-flex justify-content-center align-items-center" data-bs-dismiss="offcanvas" aria-label="Close">
                            <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/left_arrow-line.svg" alt="" />
                        </button>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <ul class="navbar-nav gap-3 custom-font mx-2 d-flex flex-column my-3">
                            <li class="main-aside-link nav-item">
                                <a class="nav-link ps-3 text-white-400 fs-xs d-flex gap-2 align-items-center" aria-current="page" href="<?php echo home_url('user-panel'); ?>">
                                    <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/dashboard-icon.svg" alt="" />
                                    <span class="">داشبورد</span>
                                </a>
                            </li>
                            <li class="main-aside-link nav-item">
                                <a class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center" href="<?php echo home_url('saved-music'); ?>">
                                    <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/save-no-fill.svg" alt="" />
                                    <span class="">موزیک های ذخیره شده</span>
                                </a>
                            </li>
                            <li class="main-aside-link nav-item active">
                                <a class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center" href="<?php echo home_url('profile'); ?>">
                                    <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/user-icon.svg" alt="" />
                                    <span class="">ویرایش اطلاعات کاربری</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-auto mb-3 mb-md-0 mx-2 d-md-flex align-items-center">
                        <a class="dir-ltr w-100 text-white d-flex justify-content-center align-content-center" href="tel:+984584587">
                            021 - 4584587
                        </a>
                    </div>
                </div>
                <figure>
                    <img class="d-block d-md-none img-fluid" src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/volna-music_logo.svg'); ?>" alt="" />
                </figure>
                <div class="d-flex gap-4 align-items-center">
                    <!-- calender -->
                    <div class="d-none d-md-flex align-items-center gap-2 p-2 bg-gray-50 rounded-2 gray-btn-hover">
                        <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/calendar-icon.svg" alt="" />
                        <div class="fs-xxs d-flex gap-1 fw-medium">
                            <span><?php echo $jalali_date; ?></span>
                        </div>
                    </div>
                    <a href="<?php echo wp_logout_url(home_url()); ?>">
                        <button class="bg-transparent log-out-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.5405 13.2252C11.703 13.0626 11.7811 12.8663 11.7746 12.636C11.7675 12.4058 11.6827 12.2094 11.5202 12.0469L10.0372 10.5638H16.2538C16.484 10.5638 16.6769 10.4858 16.8324 10.3298C16.9884 10.1743 17.0664 9.98142 17.0664 9.75117C17.0664 9.52093 16.9884 9.32779 16.8324 9.17177C16.6769 9.01629 16.484 8.93854 16.2538 8.93854H10.0372L11.5405 7.43518C11.703 7.27265 11.7843 7.07979 11.7843 6.85658C11.7843 6.63284 11.703 6.4397 11.5405 6.27718C11.378 6.11465 11.1849 6.03339 10.9611 6.03339C10.7379 6.03339 10.545 6.11465 10.3825 6.27718L7.47737 9.18233C7.3961 9.2636 7.33841 9.35163 7.30428 9.44644C7.27069 9.54124 7.25389 9.64282 7.25389 9.75117C7.25389 9.85953 7.27069 9.9611 7.30428 10.0559C7.33841 10.1507 7.3961 10.2388 7.47737 10.32L10.4028 13.2455C10.5518 13.3945 10.7379 13.469 10.9611 13.469C11.1849 13.469 11.378 13.3877 11.5405 13.2252ZM15.4411 17.0648C15.8881 17.0648 16.2708 16.9058 16.5894 16.5878C16.9074 16.2693 17.0664 15.8865 17.0664 15.4396V13.0017C17.0664 12.7715 16.9884 12.5783 16.8324 12.4223C16.6769 12.2668 16.484 12.1891 16.2538 12.1891C16.0235 12.1891 15.8304 12.2668 15.6744 12.4223C15.5189 12.5783 15.4411 12.7715 15.4411 13.0017V15.4396H4.06432V4.06276H15.4411V6.50065C15.4411 6.7309 15.5189 6.92376 15.6744 7.07925C15.8304 7.23527 16.0235 7.31328 16.2538 7.31328C16.484 7.31328 16.6769 7.23527 16.8324 7.07925C16.9884 6.92376 17.0664 6.7309 17.0664 6.50065V4.06276C17.0664 3.61581 16.9074 3.23307 16.5894 2.91451C16.2708 2.5965 15.8881 2.4375 15.4411 2.4375H4.06432C3.61737 2.4375 3.23462 2.5965 2.91607 2.91451C2.59806 3.23307 2.43906 3.61581 2.43906 4.06276V15.4396C2.43906 15.8865 2.59806 16.2693 2.91607 16.5878C3.23462 16.9058 3.61737 17.0648 4.06432 17.0648H15.4411Z" fill="white" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </nav>
            <main class="py-3 px-2 px-md-4 bg-gray-50">
                <!-- آخرین مقالات -->
                <section class="container border px-3 py-2 bg-white rounded-2">
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <div class="d-flex align-items-center">
                            <img class="img-fluid" src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/save-black-lg-icon.svg" alt="" />
                            <span class="fs-xs fw-medium ps-2">جدیدترین موزیک های منتشر شده</span>
                        </div>
                        <a class="px-2 py-1 bg-gray-50 rounded-1 gray-btn-hover" href="<?php echo home_url('/'); ?>">
                            <span class="fs-xs fw-medium">بیشتر</span>
                            <img src="<?php echo MUSIC_PANEL_URL; ?>assets/icons/arrow-left-black.svg" alt="" />
                        </a>
                    </div>
                    <!-- لیست مقالات -->
                    <div class="save-ausbildung-container d-flex justify-content-center justify-content-md-between gap-4 flex-wrap my-3">
                        <?php foreach ($latest_posts as $post) : ?>
                            <?php 
                                // دریافت تصویر شاخص
                                $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium');
                                if (!$thumbnail_url) {
                                    $thumbnail_url = MUSIC_PANEL_URL . 'assets/images/default-post.jpg';
                                }
                                
                                // دریافت دسته‌بندی
                                $categories = get_the_category($post->ID);
                                $category_name = !empty($categories) ? $categories[0]->name : '';
                            ?>
                            <div class="save-ausbildung text-black d-flex bg-white flex-md-column p-2 border justify-content-between gap-2 align-items-center rounded-2">
                                <div class="position-relative d-flex ausbildung-img-container">
                                    <img class="d-flex ausbildung-img rounded-2" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($post->post_title); ?>" />

                                </div>
                                <div class="w-md-100 h-100 text-center d-flex flex-column flex-grow-1 gap-2">
                                    <div class="d-flex flex-column">
                                        <a href="<?php echo get_permalink($post->ID); ?>" class="mb-0 fs-xs fw-medium"><?php echo esc_html($post->post_title); ?></a>
                                        <?php if (!empty($category_name)) : ?>
                                            <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="mb-0 fs-xs text-brand fw-medium">
                                                <?php echo esc_html($category_name); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-md-none">
                                        <p class="fs-x-small text-muted mb-0">
                                            <?php echo wp_trim_words(get_the_excerpt($post->ID), 15, '...'); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="w-100 px-2 d-none d-md-block">
                                    <a href="<?php echo get_permalink($post->ID); ?>" class="brand-100-hover text-brand bg-brand-100 d-flex justify-content-center align-items-center py-2 px-2 w-100 rounded-2 text-decoration-none">
                                        <span>مشاهده مقاله</span>
                                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_899_1230)">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.50546 11.1279C7.34439 10.9668 7.25391 10.7483 7.25391 10.5205C7.25391 10.2926 7.34439 10.0741 7.50546 9.91303L12.3657 5.05279C12.4449 4.97074 12.5398 4.90528 12.6446 4.86026C12.7494 4.81523 12.8621 4.79153 12.9762 4.79054C13.0903 4.78955 13.2034 4.81128 13.309 4.85448C13.4146 4.89768 13.5105 4.96148 13.5912 5.04215C13.6719 5.12281 13.7357 5.21874 13.7789 5.32433C13.8221 5.42991 13.8438 5.54305 13.8428 5.65712C13.8418 5.7712 13.8181 5.88394 13.7731 5.98876C13.728 6.09358 13.6626 6.18839 13.5805 6.26764L9.32772 10.5205L13.5805 14.7733C13.737 14.9353 13.8236 15.1523 13.8217 15.3776C13.8197 15.6029 13.7294 15.8184 13.5701 15.9777C13.4108 16.1369 13.1953 16.2273 12.97 16.2293C12.7448 16.2312 12.5277 16.1446 12.3657 15.9881L7.50546 11.1279Z" fill="#EC3A4C" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_899_1230">
                                                    <rect width="20.6197" height="20.6197" fill="white" transform="translate(0.378906 0.211128)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($latest_posts)) : ?>
                            <div class="alert alert-info w-100 text-center">
                                هیچ مقاله‌ای یافت نشد.
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </section>
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>