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

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*----------------------------------------------------*/
// Start the application
/*----------------------------------------------------*/
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

/*----------------------------------------------------*/
// Database prefix (WordPress)
/*----------------------------------------------------*/
$table_prefix = env('DATABASE_PREFIX', 'wp_');

// TODO: Implement routing and  response
// TODO: Implement kernel terminate

/* That's all, stop editing! Happy blogging. */
