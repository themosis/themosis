<?php

use Illuminate\Contracts\Http\Kernel;
use Themosis\Core\Application;

$app = new Application(THEMOSIS_ROOT);

/*----------------------------------------------------*/
// Bind interfaces
/*----------------------------------------------------*/
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

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
$kernel = $app->make(Kernel::class);
$kernel->init(
    Illuminate\Http\Request::capture()
);

/*----------------------------------------------------*/
// Database prefix (WordPress)
/*----------------------------------------------------*/
$table_prefix = env('DATABASE_PREFIX', 'wp_');

/* That's all, stop editing! Happy blogging. */
