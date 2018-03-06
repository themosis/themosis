<?php

namespace Themosis\Core\Bootstrap;

use Dotenv\Dotenv;
use Illuminate\Contracts\Foundation\Application;

class EnvironmentLoader
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Required environment variables.
     *
     * @var array
     */
    protected $required = [
        'DATABASE_NAME',
        'DATABASE_USER',
        'DATABASE_PASSWORD',
        'DATABASE_HOST',
        'WP_HOME',
        'WP_SITEURL'
    ];

    /**
     * Bootstrap the application environment.
     *
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $this->app = $app;

        try {
            $dotenv = new Dotenv($app->environmentPath(), $app->environmentFile());
            $dotenv->load();
            $dotenv->required($this->required);
        } catch (\Exception $e) {
            $app->make('log')->debug($e->getMessage());
        }
    }
}
