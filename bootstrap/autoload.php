<?php

$rootPath = dirname(__DIR__);

/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
if (!file_exists($autoload = $rootPath.DS.'vendor'.DS.'autoload.php')) {
    die("Couldn't load the Composer autoload file.");
}
require_once $autoload;

/*----------------------------------------------------*/
// Environment configuration
/*----------------------------------------------------*/

/*
 * Checks if the environment.php file
 * 1) exists, 2) isn't false, 3) isn't empty, 4) isn't default
 * If the test fails then .env is used, otherwise .env.local.php, etc.
 */
$locations = $rootPath.DS.'config'.DS.'environment.php';
if (file_exists($locations) && ($locations = require_once $locations) && count($locations) && $locations !== ['local' => 'INSERT-HOSTNAME', 'production' => 'INSERT-HOSTNAME']) {
    // They want to use this file!
    $location = new \Thms\Config\Environment($locations);
    $location = $location->which(gethostname());
    if (empty($location)) {
        die("There is an error in your environment.php file. Most likely the hostname isn't found. Note: This server's hostname is: " . gethostname());
    }
    $file = ".env.{$location}";
}

/* 
 * Tries to load the environment
 */
try {
    $env = new \Dotenv\Dotenv($rootPath, $file);
    $env->load();
    $env->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'WP_HOME', 'WP_SITEURL']);
} catch (\Exception $e) {
    die("Error in autoload.php around line 36: " . $e->getMessage());
}

/*
 * Now we can load in the appropriate config for the specified environment
 */
$location = empty($location) ? getenv('APP_ENV') : $location;
if (empty($location)) {

    // If $location is still empty then it's likely they didnt set the APP_ENV
    die("The environment variable APP_ENV could not be found");
}

/*
 * If the file doesn't load then let them know which file.
 */
if (!file_exists($config = $rootPath.DS.'config'.DS.'environments'.DS.$location.'.php')) {
    die("Failed tryig to load the file: " . $config);
}
require_once $config;

/*
 * Optionally load in a shared config file
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
define('WP_CONTENT_DIR', $rootPath.DS.'htdocs'.DS.CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME.'/'.CONTENT_DIR);
