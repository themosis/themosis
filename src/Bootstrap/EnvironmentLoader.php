<?php

namespace Thms\Bootstrap;

use Dotenv\Dotenv;
use Illuminate\Contracts\Foundation\Application;

class EnvironmentLoader
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Environment directory name.
     *
     * @var string
     */
    protected $dir = 'environment';

    /**
     * Required environment variables.
     *
     * @var array
     */
    protected $required = [
        'APP_ENV',
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

        $location = $this->detectEnvironment();
        $this->loadEnvironment($location);
    }

    /**
     * Load environment configuration files.
     *
     * @param string $location
     */
    protected function loadEnvironment($location = 'local')
    {
        $path = sprintf('%s/locations/%s.php', $this->dir, $location);

        /*
         * Load environment configuration file. Ex.: local.php
         */
        if (file_exists($file = $this->app->configPath($path))) {
            require_once $file;
        }

        /*
         * Load shared environment configuration file shared.php
         */
        if (file_exists($sharedFile = $this->app->configPath($this->dir.'/shared.php'))) {
            require_once $sharedFile;
        }
    }

    /**
     * Detect the environment.
     *
     * @return string
     */
    protected function detectEnvironment()
    {
        return env('APP_ENV', 'local');
    }
}
