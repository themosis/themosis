<?php

namespace App\Providers;

use Themosis\Core\Support\Providers\RouteServiceProvider as RouteProvider;
use Themosis\Support\Facades\Route;

class RouteServiceProvider extends RouteProvider
{
    /**
     * Main controllers namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    /**
     * Register application main routes.
     */
    public function map()
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
