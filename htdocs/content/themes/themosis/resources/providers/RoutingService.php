<?php

namespace Theme\Providers;

use Themosis\Facades\Route;
use Themosis\Foundation\ServiceProvider;

class RoutingService extends ServiceProvider
{
    /**
     * Define theme routes namespace.
     */
    public function register()
    {
        Route::group([
            'namespace' => 'Theme\Controllers'
        ], function () {
            require themosis_path('theme.resources').'routes.php';
        });
    }
}