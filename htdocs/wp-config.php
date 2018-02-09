<?php

/*----------------------------------------------------*/
// Directory separator
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

/*----------------------------------------------------*/
// Application root path
/*----------------------------------------------------*/
define('THEMOSIS_ROOT', realpath(__DIR__.'/../'));

/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
if (file_exists($autoload = THEMOSIS_ROOT.'/vendor/autoload.php')) {
    require_once $autoload;
}

/*----------------------------------------------------*/
// Bootstrap application
/*----------------------------------------------------*/
require_once dirname(__DIR__).'/bootstrap/autoload.php';

/*----------------------------------------------------*/
// Sets up WordPress vars and included files
/*----------------------------------------------------*/
require_once ABSPATH.'/wp-settings.php';
