<?php

namespace App\Http;

use Themosis\Core\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            'wp.bindings',
            'bindings',
            \Illuminate\Session\Middleware\StartSession::class
        ],
        'api' => [
            'wp.can:edit_posts',
            'bindings'
        ]
    ];

    /**
     * The application's route middleware.
     * Aliased middleware. Can be used individually or within groups.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'wp.bindings' => \Themosis\Route\Middleware\WordPressBindings::class,
        'wp.can' => \Themosis\Route\Middleware\WordPressAuthorize::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class
    ];
}
