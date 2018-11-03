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
            'wp.bindings'
        ],
        'wpapi' => [
            'wp.can:edit_posts'
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
        'wp.can' => \Themosis\Route\Middleware\WordPressAuthorize::class
    ];
}
