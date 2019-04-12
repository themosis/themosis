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
        'admin' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class
        ],
        'web' => [
            'wp.headers',
            'wp.bindings',
            'bindings',
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            'csrf',
            \Themosis\Route\Middleware\WordPressBodyClass::class
        ],
        'api' => [
            'throttle:60,1',
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
        'auth' => \App\Http\Middleware\Authenticate::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'wp.bindings' => \Themosis\Route\Middleware\WordPressBindings::class,
        'wp.can' => \Themosis\Route\Middleware\WordPressAuthorize::class,
        'wp.headers' => \Themosis\Route\Middleware\WordPressHeaders::class
    ];
}
