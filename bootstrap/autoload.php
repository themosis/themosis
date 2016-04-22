<?php

/*----------------------------------------------------*/
// Paths
/*----------------------------------------------------*/
$rootPath = dirname(__DIR__);
$webrootPath = $rootPath.DS.'htdocs';

/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
if (file_exists($autoload = $rootPath.DS.'vendor'.DS.'autoload.php')) {
    require_once $autoload;
}

/*----------------------------------------------------*/
// Environment configuration
/*----------------------------------------------------*/
/*
 * Locations
 */
if (file_exists($locations = $rootPath.DS.'config'.DS.'environment.php')) {
    $locations = require_once $locations;
} else {
    die('Unable to find your environment.php setup file.');
}

/*
 * Define environment file
 */
$location = new \Thms\Config\Environment($locations);
$location = $location->which(gethostname());
$file = empty($location) ? '.env' : ".env.{$location}";

/*
 * Load environment
 */
$env = new \Dotenv\Dotenv($rootPath, $file);
$env->load();
$env->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'WP_HOME', 'WP_SITEURL']);

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
