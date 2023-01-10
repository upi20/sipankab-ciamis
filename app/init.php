<?php
// config
$dir = __DIR__; // important
$deep_dir = ''; // important

// core
require_once __DIR__ . "/$deep_dir../core/require.php";

// ambil helper lokal
require_once __DIR__ . "/helpers.php";

// routes =====================================================================
$route = 'login';
$controller = 'LoginController';
route_get($route, $controller, 'index');
route_post($route, $controller, 'doLogin');
route_get("$route.logout", $controller, 'logout');

cekLogin();

// ganti password
$route = 'ganti_password';
$controller = 'GantiPasswordController';
route_get($route, $controller, 'index');
route_post($route, $controller, 'simpan');

// profile
$route = 'profile';
$controller = 'ProfileController';
route_get($route, $controller, 'index');
route_post($route, $controller, 'simpan');


// jika rutenya tidak terdaftar
$route = '';
$controller = 'DefaultController';
route_get($route, $controller, 'index'); // default controller runte nya kosong = ''
route_post($route, $controller, 'page_not_found'); // default controller runte nya kosong = ''