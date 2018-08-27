<?php

/*----------------------------------------------------*/
// Directory separator
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

/*----------------------------------------------------*/
// Application paths
/*----------------------------------------------------*/
define('THEMOSIS_PUBLIC_DIR', 'htdocs');
define('THEMOSIS_ROOT', realpath(__DIR__.'/../'));
define('CONTENT_DIR', 'content');
define('WP_CONTENT_DIR', realpath(THEMOSIS_ROOT.DS.THEMOSIS_PUBLIC_DIR.DS.CONTENT_DIR));

/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
if (file_exists($autoload = THEMOSIS_ROOT.'/vendor/autoload.php')) {
    require $autoload;
}

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Start the application
|--------------------------------------------------------------------------
|
| We're going to initialize the kernel instance and capture the current
| request. We won't directly manage a response from the current file.
| We let WordPress bootstrap its stuff and we'll manage the response
| once WordPress is fully loaded.
|
*/
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->init(
    Illuminate\Http\Request::capture()
);

/*----------------------------------------------------*/
// Database prefix (WordPress)
/*----------------------------------------------------*/
$table_prefix = env('DATABASE_PREFIX', 'wp_');

/* That's all, stop editing! Happy blogging. */
require_once ABSPATH.'/wp-settings.php';
