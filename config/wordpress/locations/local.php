<?php

/*----------------------------------------------------*/
// WordPress Local Configuration
/*----------------------------------------------------*/
// Database
define('DB_NAME', env('DATABASE_NAME'));
define('DB_USER', env('DATABASE_USER'));
define('DB_PASSWORD', env('DATABASE_PASSWORD'));
define('DB_HOST', env('DATABASE_HOST') ? env('DATABASE_HOST') : 'localhost');

// WordPress URLs
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));

// Jetpack
define('JETPACK_DEV_DEBUG', env('JETPACK_DEV_DEBUG', true));

// Encoding
define('THEMOSIS_CHARSET', 'UTF-8');

// Development
define('SAVEQUERIES', env('APP_DEBUG', true));
define('WP_DEBUG', env('APP_DEBUG', true));
define('WP_DEBUG_DISPLAY', env('APP_DEBUG', true));
define('SCRIPT_DEBUG', env('APP_DEBUG', true));
