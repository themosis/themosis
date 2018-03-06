<?php

namespace Themosis\Core\Bootstrap;

use Illuminate\Contracts\Foundation\Application;

class RegisterProviders
{
    /**
     * Bootstrap application service providers.
     *
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
