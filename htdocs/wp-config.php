<?php

/*----------------------------------------------------*/
// Directory separator
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

/*----------------------------------------------------*/
// Bootstrap WordPress
/*----------------------------------------------------*/
require_once(dirname(__DIR__).DS.'bootstrap'.DS.'start.php');

/*----------------------------------------------------*/
// Sets up WordPress vars and included files
/*----------------------------------------------------*/
require_once(ABSPATH.'wp-settings.php');
