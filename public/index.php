<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// *** เพิ่ม 2 บรรทัดนี้เพื่อแก้ปัญหา Laravel ใน Subdirectory ของ Shared Hosting ***
 $_SERVER['SCRIPT_NAME'] = '/index.php';
 $_SERVER['REQUEST_URI'] = str_replace('/care/public', '', $_SERVER['REQUEST_URI']);

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
