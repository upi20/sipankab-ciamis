<?php
// Start the session
session_start();
date_default_timezone_set('Asia/Jakarta');
$composer_autoload_path = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composer_autoload_path)) {
    require_once $composer_autoload_path;
}

// ambil core file
require_once __DIR__ . '/global_helper.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/config.php';

// ambil library
require_once __DIR__ . "/../library/StringGenerator.php";

// controller and model
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Model.php';
