<?php

use Illuminate\Contracts\Http\Kernel;
use Themosis\Core\Application;

/**
 * Plugin Name: Themosis Framework Loader
 * Plugin URI: https://framework.themosis.com
 * Description: Themosis framework core components and mu-plugins auto-loader.
 * Author: Julien Lambé
 * Author URI: https://www.themosis.com
 * Version: 1.4.0
 * License: GPL-2.0-or-later
 */
if (! class_exists('Themosis\Core\Application')) {
    return;
}

$app = Application::getInstance();

// WordPress Administration middleware support.
$app->manageAdmin(Kernel::class, $app['request']);

// Load application mu-plugins.
$app->loadPlugins(__DIR__);

// Register application hooks.
$app->registerConfiguredHooks();
