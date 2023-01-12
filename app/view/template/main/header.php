<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- FAVICON -->
    <link rel="icon" href="<?= asset('assets/favicon/favicon.ico') ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= asset('assets/favicon/apple-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= asset('assets/favicon/apple-icon-60x60.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= asset('assets/favicon/apple-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= asset('assets/favicon/apple-icon-76x76.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= asset('assets/favicon/apple-icon-114x114.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= asset('assets/favicon/apple-icon-120x120.png') ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= asset('assets/favicon/apple-icon-144x144.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= asset('assets/favicon/apple-icon-152x152.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/favicon/apple-icon-180x180.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= asset('assets/favicon/android-icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('assets/favicon/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= asset('assets/favicon/favicon-96x96.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('assets/favicon/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset('assets/favicon/manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="theme-color" content="#0F84CA">
    <meta name="msapplication-TileImage" content="<?= asset('assets/favicon/icon-144x144.png') ?>">

    <!-- TITLE -->
    <title><?= $title ?> | SIPANKAB CIAMIS</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="<?= asset('assets/template/admin/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="<?= asset('assets/template/admin/css/style.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/template/admin/css/dark-style.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/template/admin/css/transparent-style.css') ?>" rel="stylesheet">
    <link href="<?= asset('assets/template/admin/css/skin-modes.css') ?>" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="<?= asset('assets/template/admin/css/icons.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/template/admin/plugins/fontawesome-free-5.15.4-web/css/all.min.css') ?>" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="<?= asset('assets/template/admin/colors/color1.css') ?>" />
    <link href="<?= asset('assets/template/admin/plugins/sweet-alert/sweetalert2.css') ?>" rel="stylesheet" />

    <!-- JQUERY JS -->
    <script src="<?= asset('assets/template/admin/js/jquery.min.js') ?>"></script>
    <style>
        .swal2-container {
            z-index: 9999999 !important;
        }
    </style>

</head>

<body class="app ltr light-mode horizontal">
    <div id="global-spinner" style="position: fixed;right: 38px;top: 22px;z-index: 10; display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>



    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <div class="header sticky hor-header">
                <div class="main-container container">
                    <div class="d-flex flex-row  justify-content-between">
                        <div>
                            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)">
                            </a>
                        </div>
                        <div>
                            <a class="logo-horizontal " href="<?= base_url() ?>">
                                <!-- <a class="logo-horizontal " href="{{ url('/') }}">
                                <img src="{{ asset(settings()->get(set_admin('app.foto_light_landscape_mode'))) }}" class="header-brand-img desktop-logo" alt="logo">
                                <img src="{{ asset(settings()->get(set_admin('app.foto_dark_landscape_mode'))) }}" class="header-brand-img light-logo1" alt="logo">
                            </a> -->
                                <img src="<?= asset($setting['logo_landscape']) ?>" altSrc="<?= asset('assets/template/admin/logo.png') ?>" onerror="this.src = $(this).attr('altSrc')" class="header-brand-img desktop-logo" style="max-height: 50px;" alt="logo">
                                <img src="<?= asset($setting['logo_white_landscape']) ?>" altSrc="<?= asset('assets/template/admin/logo.png') ?>" onerror="this.src = $(this).attr('altSrc')" class="header-brand-img light-logo1" style="max-height: 50px;" alt="logo">
                            </a>
                        </div>
                        <!-- LOGO -->

                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <!-- SEARCH -->
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        <div class="d-flex country">
                                            <a class="nav-link icon theme-layout layout-setting">
                                                <span class="dark-layout"><i class="far fa-moon"></i></span>
                                                <span class="light-layout"><i class="far fa-sun"></i></span>
                                            </a>
                                        </div>
                                        <!-- Theme-Layout -->
                                        <div class="dropdown d-flex">
                                            <a class="nav-link icon full-screen-link nav-link-bg">
                                                <i class="fas fa-expand fullscreen-button"></i>
                                            </a>
                                        </div>
                                        <!-- FULL-SCREEN -->
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                                <img src="<?= asset('assets/template/admin/profile.png') ?>" alt="profile-user" class="avatar  profile-user brround cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold"><?= $_SESSION['auth']['nama'] ?></h5>
                                                        <small class="text-muted"><?= $_SESSION['auth']['email'] ?></small>
                                                    </div>
                                                </div>
                                                <?php if (!route_has('profile')) : ?>
                                                    <a class="dropdown-item" href="<?= route('profile', ['cr' => get('r')]) ?>">
                                                        <i class="dropdown-icon fe fe-user"></i> Profil
                                                    </a>
                                                <?php endif ?>

                                                <?php if (!route_has('ganti_password')) : ?>
                                                    <a class="dropdown-item" href="<?= route('ganti_password', ['cr' => get('r')]) ?>">
                                                        <i class="dropdown-icon fe fe-settings"></i> Ganti Password
                                                    </a>
                                                <?php endif ?>
                                                <a class="dropdown-item" href="<?= route('login.logout') ?>">
                                                    <i class="dropdown-icon fe fe-alert-circle"></i> Keluar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /app-Header -->

            <!--APP-SIDEBAR-->

            <div class="sticky">
                <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                <div class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="<?= base_url() ?>">
                            <img src="<?= asset('assets/template/admin/logo.png') ?>" altSrc="<?= asset('assets/template/admin/logo.png') ?>" onerror="this.src = $(this).attr('altSrc')" style="max-height: 53px;" class="header-brand-img light-logo1" alt="logo">
                            <img src="<?= asset('assets/template/admin/logo-grid.png') ?>" altSrc="<?= asset('assets/template/admin/logo-grid.png') ?>" onerror="this.src = $(this).attr('altSrc')" style="max-height: 53px;" class="header-brand-img light-logo" alt="logo">
                            <img src="<?= asset('assets/template/admin/logo.png') ?>" altSrc="<?= asset('assets/template/admin/logo.png') ?>" onerror="this.src = $(this).attr('altSrc')" style="max-height: 53px;" class="header-brand-img desktop-logo" alt="logo">
                            <img src="<?= asset('assets/template/admin/logo-grid.png') ?>" altSrc="<?= asset('assets/template/admin/logo-grid.png') ?>" onerror="this.src = $(this).attr('altSrc')" style="max-height: 53px;" class="header-brand-img toggle-logo" alt="logo">
                        </a>
                        <!-- LOGO -->
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                            </svg></div>
                        <ul class="side-menu">

                            <li class="slide">
                                <a class="side-menu__item <?= route_active_class('', 'active') ?>" data-bs-toggle="slide" href="<?= base_url() ?>">
                                    <i class="side-menu__icon fas fa-home"></i>
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item <?= route_active_class('kecamatan', 'active') ?>" data-bs-toggle="slide" href="<?= route('kecamatan') ?>">
                                    <i class="side-menu__icon fas fa-clipboard-list"></i>
                                    <span class="side-menu__label">Kecamatan</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item <?= route_active_class('calon', 'active') ?>" data-bs-toggle="slide" href="<?= route('calon') ?>">
                                    <i class="side-menu__icon fas fa-user"></i>
                                    <span class="side-menu__label">Calon</span>
                                </a>
                            </li>


                            <li class="slide">
                                <a class="side-menu__item <?= route_active_class('tahapan', 'active') ?>  <?= route_active_class('tahapan.nilai', 'active') ?>" data-bs-toggle="slide" href="<?= route('tahapan') ?>">
                                    <i class="side-menu__icon fas fa-edit"></i>
                                    <span class="side-menu__label">Tahapan</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item <?= route_active_class('calon_nilai', 'active') ?>" data-bs-toggle="slide" href="<?= route('calon_nilai') ?>">
                                    <i class="side-menu__icon fas fa-user-edit"></i>
                                    <span class="side-menu__label">Calon Nilai</span>
                                </a>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="<?= route('login.logout') ?>">
                                    <i class="side-menu__icon fas fa-sign-out-alt"></i>
                                    <span class="side-menu__label">Keluar</span>
                                </a>
                            </li>
                        </ul>
                        <div class="slide-right" id="slide-right">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!--/APP-SIDEBAR-->
            </div>

            <!--app-content open-->
            <div class="main-content mt-0 hor-content">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container container">