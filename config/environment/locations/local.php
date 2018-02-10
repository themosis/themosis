<?php

/*----------------------------------------------------*/
// Local config
/*----------------------------------------------------*/
// Database
define('DB_NAME', getenv('DATABASE_NAME'));
define('DB_USER', getenv('DATABASE_USER'));
define('DB_PASSWORD', getenv('DATABASE_PASSWORD'));
define('DB_HOST', getenv('DATABASE_HOST') ? getenv('DATABASE_HOST') : 'localhost');

// WordPress URLs
define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

// Jetpack
define('JETPACK_DEV_DEBUG', true);

// Encoding
define('THEMOSIS_CHARSET', 'UTF-8');

// Development
define('SAVEQUERIES', true);
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('SCRIPT_DEBUG', true);

// Themosis framework
define('THEMOSIS_ERROR', true);
define('BS', true);
