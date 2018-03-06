<?php

/*----------------------------------------------------*/
// Directory separator
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

/*----------------------------------------------------*/
// Application paths
/*----------------------------------------------------*/
define('THEMOSIS_PUBLIC_DIR', 'htdocs');
define('THEMOSIS_ROOT', realpath(__DIR__.'/../'));
define('CONTENT_DIR', 'content');
define('WP_CONTENT_DIR', realpath(THEMOSIS_ROOT.DS.THEMOSIS_PUBLIC_DIR.DS.CONTENT_DIR));

/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
if (file_exists($autoload = THEMOSIS_ROOT.'/vendor/autoload.php')) {
    require $autoload;
}

/*----------------------------------------------------*/
// Bootstrap application
/*----------------------------------------------------*/
require dirname(__DIR__).'/bootstrap/start.php';

/*----------------------------------------------------*/
// Set up WordPress vars and included files
/*----------------------------------------------------*/
require_once ABSPATH.'/wp-settings.php';
