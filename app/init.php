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
