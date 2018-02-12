<?php

namespace Thms\Core\Http;

use Illuminate\Contracts\Foundation\Application;
use Thms\Bootstrap\ConfigurationLoader;

class Kernel implements \Illuminate\Contracts\Http\Kernel
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->bootstrap();
    }

    /**
     * List of bootstrap classes.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Thms\Bootstrap\EnvironmentLoader::class,
        \Thms\Bootstrap\ConfigurationLoader::class,
        \Thms\Bootstrap\ExceptionHandler::class,
    ];

    /**
     * Bootstrap the application.
     */
    public function bootstrap()
    {
        if (!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
    }

    /**
     * Return the bootstrappers array.
     *
     * @return array
     */
    protected function bootstrappers()
    {
        return $this->bootstrappers;
    }

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }

    public function terminate($request, $response)
    {
        // TODO: Implement terminate() method.
    }

    public function getApplication()
    {
        // TODO: Implement getApplication() method.
    }
}
