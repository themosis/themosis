<?php

namespace Thms\Core\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler implements ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var array
     */
    protected $internalDontReport = [
        HttpException::class,
        HttpResponseException::class
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $e
     */
    public function report(Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if (method_exists($e, 'report')) {
            return $e->report();
        }

        // TODO: Log exception
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        return $request->expectsJson() ?
            $this->prepareJsonResponse($request, $e) :
            $this->prepareResponse($request, $e);
    }

    /**
     * Render an exception to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Exception                                        $e
     */
    public function renderForConsole($output, Exception $e)
    {
        // TODO: Implement renderForConsole() method.
    }

    /**
     * Prepare exception for rendering.
     *
     * @param Exception $e
     *
     * @return Exception
     */
    protected function prepareException(Exception $e)
    {
        // TODO: Prepare core exceptions
        return $e;
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param Exception $e
     *
     * @return bool
     */
    protected function shouldntReport(Exception $e)
    {
        $dontReport = array_merge($this->dontReport, $this->internalDontReport);

        return ! is_null(Arr::first($dontReport, function ($type) use ($e) {
            return $e instanceof $type;
        }));
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param $request
     * @param Exception $e
     */
    protected function prepareJsonResponse($request, Exception $e)
    {
        // TODO: Implement JSON Response exception.
    }

    /**
     * Prepare a response for the given exception.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception                $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $e)
    {
        if (! $this->isHttpException($e) && config('app.debug')) {
            // TODO: Implement ErrorException response.
            dd("Error exception");
        }

        return $this->toIlluminateResponse(
            $this->renderHttpException($e)
        );
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param Exception $e
     *
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException;
    }

    /**
     * Map the given exception into an Illuminate response.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param Exception                                  $e
     *
     * @return \Illuminate\Http\Response
     */
    protected function toIlluminateResponse($response, Exception $e)
    {
        // TODO: Implement IlluminateResponse conversion
    }

    protected function renderHttpException(HttpException $e)
    {
        // TODO: Implement HTTPException rendering
    }
}
