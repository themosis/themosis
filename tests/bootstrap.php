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
// Some constants :)
/*----------------------------------------------------*/
define('CONTENT_DIR', 'content');
define('WP_CONTENT_DIR', THEMOSIS_ROOT.DS.CONTENT_DIR);

/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
require __DIR__.'/../vendor/autoload.php';
