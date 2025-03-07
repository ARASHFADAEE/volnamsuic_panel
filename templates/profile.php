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

$current_user = wp_get_current_user();


?>





<!DOCTYPE html>
<html <?php language_attributes();?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>پنل کاربری - <?php bloginfo('name'); ?></title>
    <link
      rel="icon"
      href="/assets/icons/iran-ausbildung-icon.png"
      type="image/x-icon"
    />
    <?php wp_head(); ?>

  </head>
  <body>
    <!-- main nav -->
    <aside
      class="position-fixed main-aside navbar d-none d-md-flex bg-c-black navbar-expand-md py-0 h-100"
    >
      <!-- bottom nav -->
      <nav
        class="d-none d-md-flex flex-column w-100 px-0 h-100 text-white-400 bg-black-700"
      >
        <div class="container-lg d-flex flex-column px-3 py-2">
          <!-- left -->
          <div>
            <div
              class="d-flex align-items-center gap-2 justify-content-center pb-1 border-bottom border-2 border-gray-700"
            >
              <img src="https://volnamusic.ir/new/wp-content/themes/volnamusic-v2/assets/icons/volna-music_logo.svg" alt="" />

            </div>
            <ul class="navbar-nav gap-3 custom-font d-flex flex-column my-3">
              <li class="main-aside-link nav-item">
                <a
                  class="nav-link ps-3 text-white-400 fs-xs d-flex gap-2 align-items-center"
                  aria-current="page"
                  href="<?php echo home_url('user-panel'); ?>"
                >
                  <img src="/assets/icons/dashboard-icon.svg" alt="" />
                  <span class="d-none d-xl-inline">داشبورد</span>
                </a>
              </li>
              <li class="main-aside-link nav-item">
                <a
                  class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center"
                  href="<?php echo home_url('saved-music'); ?>"
                >
                  <img src="/assets/icons/save-no-fill.svg" alt="" />
                  <span class="d-none d-xl-inline"
                    >موزیک های ذخیره شده</span
                  >
                </a>
              </li>

              <li class="main-aside-link nav-item active">
                <a
                  class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center"
                  href="<?php echo home_url('profile'); ?>"
                >
                  <img src="/assets/icons/user-icon.svg" alt="" />
                  <span class="d-none d-xl-inline">ویرایش اطلاعات کاربری</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="mt-auto pb-3 mb-md-0 mx-2 d-md-flex align-items-center">
          <a
            class="dir-ltr w-100 text-white d-flex justify-content-center align-content-center"
            href="tel:+984584587"
          >
            <span class="d-none d-xl-inline">021 - 4584587</span>
            <img
              class="d-inline d-xl-none"
              src="/assets/icons/phone-icon.svg"
              alt=""
            />
          </a>
        </div>
      </nav>
    </aside>
    <section
      class="main-container h-100 d-flex flex-column flex-grow-1 bg-gray-50"
    >
      <nav class="w-100">
        <div
          class="d-flex px-3 py-2 h-auto bg-black-700 bg-md-white justify-content-between align-items-center"
        >
          <!-- user info -->
          <div class="d-none d-md-flex gap-2">
            <figure>
              <img
                class="user-img img-fluid rounded-circle border border-3"
                src="/assets/images/user-img.jpg"
                alt=""
              />
            </figure>
            <div class="d-flex flex-column justify-content-evenly">
              <p class="fs-xs fw-medium">محمد پور احمدی</p>
              <p class="fs-xxs text-gray-400">09122545658</p>
            </div>
          </div>
          <button
            class="hamburger-icon bg-gray-700 d-flex align-items-center justify-content-center navbar-toggler d-block d-md-none shadow-none border-0 rounded-2"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar"
          >
            <img
              class="navbar-toggler"
              src="../assets/icons/hamburger-icon.svg"
            />
          </button>
          <div
            class="offcanvas offcanvas-start w-75 bg-black-700"
            tabindex="-1"
            id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel"
          >
            <div class="offcanvas-header justify-content-between">
              <!-- user info -->
              <div class="d-flex gap-2">
                <figure>
                  <img
                    class="user-img img-fluid rounded-circle border border-3"
                    src="/assets/images/user-img.jpg"
                    alt=""
                  />
                </figure>
                <div
                  class="d-flex flex-column text-gray-400 justify-content-evenly"
                >
                  <p class="fs-xs fw-medium">محمد پور احمدی</p>
                  <p class="fs-xxs">09122545658</p>
                </div>
              </div>
              <button
                class="border-0 bg-gray-700 rounded-2 p-2 d-flex justify-content-center align-items-center"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
              >
                <img src="../assets/icons/left_arrow-line.svg" alt="" />
              </button>
            </div>
            <div class="mt-2 mt-md-0">
              <ul
                class="navbar-nav gap-3 custom-font mx-2 d-flex flex-column my-3"
              >
                <li class="main-aside-link nav-item">
                  <a
                    class="nav-link ps-3 text-white-400 fs-xs d-flex gap-2 align-items-center"
                    aria-current="page"
                    href="<?php echo home_url('user-panel'); ?>"
                  >
                    <img src="/assets/icons/dashboard-icon.svg" alt="" />
                    <span class="">داشبورد</span>
                  </a>
                </li>
                <li class="main-aside-link nav-item">
                  <a
                    class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center"
                    href="<?php echo home_url('saved-music'); ?>"
                  >
                    <img src="/assets/icons/save-no-fill.svg" alt="" />
                    <span class="">موزیک های ذخیره شده</span>
                  </a>
                </li>


                <li class="main-aside-link nav-item active">
                  <a
                    class="nav-link ps-3 text-white-400 d-flex gap-2 align-items-center"
                    href="<?php echo home_url('profile'); ?>"
                  >
                    <img src="/assets/icons/user-icon.svg" alt="" />
                    <span class="">ویرایش اطلاعات کاربری</span>
                  </a>
                </li>
              </ul>
            </div>
            <div class="mt-auto mb-3 mb-md-0 mx-2 d-md-flex align-items-center">
              <a
                class="dir-ltr w-100 text-white d-flex justify-content-center align-content-center"
                href="tel:+984584587"
              >
                021 - 4584587
              </a>
            </div>
          </div>
          <figure>
            <img
              class="d-block d-md-none img-fluid"
              src="https://volnamusic.ir/new/wp-content/themes/volnamusic-v2/assets/icons/volna-music_logo.svg"
              alt=""
            />
          </figure>
          <div class="d-flex gap-4 align-items-center">
            <!-- calender -->
            <div
              class="d-none d-md-flex align-items-center gap-2 p-2 bg-gray-50 rounded-2 gray-btn-hover"
            >
              <img src="/assets/icons/calendar-icon.svg" alt="" />
              <div class="fs-xxs d-flex gap-1 fw-medium">
                <span>پنج شنبه </span>
                <span>1402/03/02</span>
              </div>
            </div>
            <a href="<?php echo wp_logout_url(home_url()); ?>">
            <button class="bg-transparent log-out-icon">
              <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M11.5405 13.2252C11.703 13.0626 11.7811 12.8663 11.7746 12.636C11.7675 12.4058 11.6827 12.2094 11.5202 12.0469L10.0372 10.5638H16.2538C16.484 10.5638 16.6769 10.4858 16.8324 10.3298C16.9884 10.1743 17.0664 9.98142 17.0664 9.75117C17.0664 9.52093 16.9884 9.32779 16.8324 9.17177C16.6769 9.01629 16.484 8.93854 16.2538 8.93854H10.0372L11.5405 7.43518C11.703 7.27265 11.7843 7.07979 11.7843 6.85658C11.7843 6.63284 11.703 6.4397 11.5405 6.27718C11.378 6.11465 11.1849 6.03339 10.9611 6.03339C10.7379 6.03339 10.545 6.11465 10.3825 6.27718L7.47737 9.18233C7.3961 9.2636 7.33841 9.35163 7.30428 9.44644C7.27069 9.54124 7.25389 9.64282 7.25389 9.75117C7.25389 9.85953 7.27069 9.9611 7.30428 10.0559C7.33841 10.1507 7.3961 10.2388 7.47737 10.32L10.4028 13.2455C10.5518 13.3945 10.7379 13.469 10.9611 13.469C11.1849 13.469 11.378 13.3877 11.5405 13.2252ZM15.4411 17.0648C15.8881 17.0648 16.2708 16.9058 16.5894 16.5878C16.9074 16.2693 17.0664 15.8865 17.0664 15.4396V13.0017C17.0664 12.7715 16.9884 12.5783 16.8324 12.4223C16.6769 12.2668 16.484 12.1891 16.2538 12.1891C16.0235 12.1891 15.8304 12.2668 15.6744 12.4223C15.5189 12.5783 15.4411 12.7715 15.4411 13.0017V15.4396H4.06432V4.06276H15.4411V6.50065C15.4411 6.7309 15.5189 6.92376 15.6744 7.07925C15.8304 7.23527 16.0235 7.31328 16.2538 7.31328C16.484 7.31328 16.6769 7.23527 16.8324 7.07925C16.9884 6.92376 17.0664 6.7309 17.0664 6.50065V4.06276C17.0664 3.61581 16.9074 3.23307 16.5894 2.91451C16.2708 2.5965 15.8881 2.4375 15.4411 2.4375H4.06432C3.61737 2.4375 3.23462 2.5965 2.91607 2.91451C2.59806 3.23307 2.43906 3.61581 2.43906 4.06276V15.4396C2.43906 15.8865 2.59806 16.2693 2.91607 16.5878C3.23462 16.9058 3.61737 17.0648 4.06432 17.0648H15.4411Z"
                  fill="white"
                />
              </svg>
            </button>
            </a>

          </div>
        </div>
      </nav>
      <main class="py-3 px-2 px-md-4 bg-gray-50">
        <!-- table's -->
        <div class="container px-1 my-3">
          <div class="d-flex justify-content-center">
            <div class="w-100 w-md-45 shadow bg-white rounded-3 py-3">
              <div class="border-bottom pb-2 px-1">
                <a
                  class="nav-link ps-3 d-flex gap-2 align-items-center"
                  href="#"
                >
                  <img src="/assets/icons/user-black-icon.svg" alt="" />
                  <span class="fw-medium">ویرایش اطلاعات کاربری</span>
                </a>
              </div>
              <form class="d-flex flex-column gap-2 px-4 pb-2">
                <div
                  class="d-flex justify-content-center flex-column align-items-center gap-3 pt-3 pb-3"
                >
                  <figure>
                    <img
                      class="border border-4 img-fluid rounded-circle user-img-lg"
                      src="/assets/images/user-img.jpg"
                      alt=""
                    />
                  </figure>
                  <label 
                  class="bg-gray-10 pointer fs-xs py-1 px-2 fw-medium rounded-1 gray-btn-hover"
                  for="browse-user-img">ویرایش تصویر پروفایل</label>
                  <input
                    hidden
                    id="browse-user-img"
                    type="file"
                    accept=".jpg,.jpeg,.png"
                  >
                  </input>
                </div>
                <div class="row pb-2">
                  <div class="col-xl-6">
                    <label class="fs-xs mb-2 ps-1 fs-extra-small fw-bold" for=""
                      >نام</label
                    >
                    <input
                    value="علی"
                      class="user-info-felids fw-medium bg-gray-10 w-100 rounded-2 px-2 py-medium text-gray-600"
                      type="text"
                      placeholder="نام را وارد کنید"
                    />
                  </div>
                  <div class="col-xl-6">
                    <label class="fs-xs mb-2 ps-1 fs-extra-small fw-bold" for=""
                      >نام خانوادگی</label
                    >
                    <input
                      value="مختاری"
                      class="user-info-felids fw-medium bg-gray-10 w-100 rounded-2 px-2 py-medium text-gray-600"
                      type="text"
                      placeholder="نام خانوادگی را وارد کنید"
                    />
                  </div>
                </div>
                <div class="row pb-2">
                  <div class="col-xl-6">
                    <label class="fs-xs mb-2 ps-1 fs-extra-small fw-bold" for=""
                      >شماره تماس</label
                    >
                    <input
                      value="09357532303"
                      class="user-info-felids phone-input fw-medium bg-gray-10 w-100 rounded-2 px-2 py-medium text-gray-600"
                      type="text"
                      placeholder="مانند : 000 0000 0912"
                    />
                  </div>
                  <div class="col-xl-6">
                    <label class="fs-xs mb-2 ps-1 fs-extra-small fw-bold" for=""
                      >آدرس ایمیل</label
                    >
                    <input
                      value="alimokhtari7902@gmail.com"
                      class="user-info-felids fw-medium bg-gray-10 w-100 rounded-2 px-2 py-medium text-gray-600"
                      type="text"
                      placeholder="مانند : example@gmail.com"
                    />
                  </div>
                </div>
                <div class="row pb-2">
                  <div class="col-xl-6">
                    <label class="fs-xs mb-2 ps-1 fs-extra-small fw-bold" for=""
                      >رمز عبور قبلی</label
                    >
                    <input
                      value="********"
                      class="user-info-felids fw-medium bg-gray-10 w-100 rounded-2 px-2 py-medium text-gray-600"
                      type="password"
                      placeholder="رمز عبور قبلی"
                    />
                  </div>
                  <div class="col-xl-6">
                    <label class="fs-xs mb-2 ps-1 fs-extra-small fw-bold" for=""
                      >رمز عبور جدید</label
                    >
                    <input
                      class="user-info-felids fw-medium bg-gray-10 w-100 rounded-2 px-2 py-medium text-gray-600"
                      type="password"
                      placeholder="رمزعبور جدید"
                    />
                  </div>
                </div>
                <div class="d-flex justify-content-end" >
                  <button class="bg-brand text-white p-2 rounded-2 fs-xs" >ویرایش اطلاعات</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </section>
    <script src="/js/bootstrap/bootstrap.bundle.min.js"></script>
  </body>
</html>
