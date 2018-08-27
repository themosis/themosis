<?php

use App\Http\Kernel;
use Themosis\Core\Application;

$app = Application::getInstance();
$kernel = $app->make(Kernel::class);
$response = $kernel->handle($app['request']);
$response->send();
