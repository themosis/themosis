<?php

namespace Themosis\Core\Bootstrap;

use Illuminate\Contracts\Foundation\Application;

class BootProviders
{
    /**
     * Bootstrap the application.
     *
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $app->boot();
    }
}
