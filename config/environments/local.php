<?php

/*----------------------------------------------------*/
// Local config
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
define('SAVEQUERIES', true);
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);

// Themosis framework
define('THEMOSIS_ERROR_DISPLAY', true);
define('THEMOSIS_ERROR_SHUTDOWN', true);
define('THEMOSIS_ERROR_REPORT', -1);