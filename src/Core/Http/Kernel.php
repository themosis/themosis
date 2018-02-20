<?php

namespace Thms\Core\Http;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Thms\Core\Http\Events\RequestHandled;
use Throwable;

class Kernel implements \Illuminate\Contracts\Http\Kernel
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * List of bootstrap classes.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Thms\Core\Bootstrap\EnvironmentLoader::class,
        \Thms\Core\Bootstrap\ConfigurationLoader::class,
        \Thms\Core\Bootstrap\ExceptionHandler::class,
        \Thms\Core\Bootstrap\RegisterFacades::class
    ];

    /**
     * Bootstrap the application.
     */
    public function bootstrap()
    {
        if (! $this->app->hasBeenBootstrapped()) {
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

    /**
     * Handle application request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request)
    {
        try {
            $request->enableHttpMethodParameterOverride();
            $response = $this->sendRequestThroughRouter($request);
        } catch (Exception $e) {
            $this->reportException($e);
            $response = $this->renderException($request, $e);
        } catch (Throwable $e) {
            $this->reportException($e = new FatalThrowableError($e));
            $response = $this->renderException($request, $e);
        }

        $this->app['events']->dispatch(
            new RequestHandled($request, $response)
        );

        return $response;
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function sendRequestThroughRouter($request)
    {
        $this->app->instance('request', $request);

        Facade::clearResolvedInstance('request');

        $this->bootstrap();

        //TODO: Create valid HTTP response and return it
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param \Exception $e
     */
    protected function reportException(Exception $e)
    {
        $this->app[ExceptionHandler::class]->report($e);
    }

    /**
     * Render the exception to a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Exception $e)
    {
        return $this->app[ExceptionHandler::class]->render($request, $e);
    }

    public function terminate($request, $response)
    {
        // TODO: Implement terminate() method.
    }

    /**
     * Return the application instance.
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->app;
    }
}
