<?php

/*----------------------------------------------------*/
// Production config
/*----------------------------------------------------*/
// Database
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');

// WordPress URLs
define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

// Development
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);

// Themosis framework
define('THEMOSIS_ERROR_DISPLAY', false);
define('THEMOSIS_ERROR_SHUTDOWN', false);
define('THEMOSIS_ERROR_REPORT', 0);