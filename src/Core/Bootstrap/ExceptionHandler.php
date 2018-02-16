<?php

namespace Thms\Core\Bootstrap;

use Illuminate\Contracts\Foundation\Application;

class ExceptionHandler
{
    /**
     * @var Application
     */
    protected $app;

    public function bootstrap(Application $app)
    {
        $this->app = $app;

        error_reporting(-1);
    }
}
