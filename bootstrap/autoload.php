<?php

use Dotenv\Dotenv;
use Thms\Bootstrap\EnvironmentLoader;
use Thms\Core\Application;

$application = new Application(THEMOSIS_ROOT);

$dotenv = new Dotenv(THEMOSIS_ROOT);

$bootstrap = new EnvironmentLoader(THEMOSIS_ROOT, $dotenv);
$bootstrap->bootstrap();

/*
 * Load environment configuration
 */
// If .env file selected, default its location to local configuration.
$location = ('.env' === $file) ? 'local' : $location;
if (file_exists($config = $rootPath.DS.'config'.DS.'environments'.DS.$location.'.php')) {
    require_once $config;
}

/*
 * Include shared configuration
 */
if (file_exists($shared = $rootPath.DS.'config'.DS.'shared.php')) {
    require_once $shared;
}

/*----------------------------------------------------*/
// Error handling
/*----------------------------------------------------*/
if (defined('THEMOSIS_ERROR') && THEMOSIS_ERROR) {
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}

/*----------------------------------------------------*/
// Constants
/*----------------------------------------------------*/
define('THEMOSIS_STORAGE', $rootPath.DS.'storage');
define('CONTENT_DIR', 'content');
define('WP_CONTENT_DIR', $webrootPath.DS.CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME.'/'.CONTENT_DIR);
