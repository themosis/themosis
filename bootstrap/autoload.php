<?php

use Illuminate\Contracts\Http\Kernel;
use Thms\Core\Application;

$app = new Application(THEMOSIS_ROOT);

/*----------------------------------------------------*/
// Bind interfaces
/*----------------------------------------------------*/
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

/*----------------------------------------------------*/
// Start the application
/*----------------------------------------------------*/
$app->make(Kernel::class);

/*----------------------------------------------------*/
// Database prefix (WordPress)
/*----------------------------------------------------*/
$table_prefix = env('DATABASE_PREFIX', 'wp_');

/*----------------------------------------------------*/
// Error handling
/*----------------------------------------------------*/
/*if (defined('THEMOSIS_ERROR') && THEMOSIS_ERROR) {
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}*/

/*----------------------------------------------------*/
// Constants
/*----------------------------------------------------*/
//define('THEMOSIS_STORAGE', $rootPath.DS.'storage');
