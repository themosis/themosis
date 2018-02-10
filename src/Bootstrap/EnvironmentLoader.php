<?php

namespace Thms\Bootstrap;

use Dotenv\Dotenv;

class EnvironmentLoader
{
    /**
     * @var Dotenv
     */
    protected $env;

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
     * EnvironmentLoader constructor.
     *
     * @param string $path Application root path.
     * @param Dotenv $env
     */
    public function __construct($path, Dotenv $env)
    {
        $this->env = $env;
    }

    /**
     * Bootstrap the application environment.
     */
    public function bootstrap()
    {
        $this->env->load();
        $this->env->required($this->required);
        $location = $this->detectEnvironment();
        $this->loadEnvironment($location);

        return $this;
    }

    /**
     * Load environment configuration files.
     *
     * @param string $location
     */
    protected function loadEnvironment($location = 'local')
    {
        file_exists($config = $rootPath.DS.'config'.DS.'environments'.DS.$location.'.php');
    }

    /**
     * Detect the environment.
     *
     * @return string
     */
    protected function detectEnvironment()
    {
        $environment = getenv('APP_ENV');

        if (empty($environment)) {
            return 'local';
        }

        return $environment;
    }
}
