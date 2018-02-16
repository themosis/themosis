<?php

/*----------------------------------------------------*/
// WordPress Production Configuration
/*----------------------------------------------------*/
// Database
define('DB_NAME', config('database.connections.mysql.database'));
define('DB_USER', config('database.connections.mysql.username'));
define('DB_PASSWORD', config('database.connections.mysql.password'));
define('DB_HOST', config('database.connections.mysql.host'));

// WordPress URLs
define('WP_HOME', config('app.url'));
define('WP_SITEURL', config('app.wp'));

// Jetpack
define('JETPACK_DEV_DEBUG', config('app.debug'));

// Development
define('SAVEQUERIES', config('app.debug'));
define('WP_DEBUG', config('app.debug'));
define('WP_DEBUG_DISPLAY', config('app.debug'));
define('SCRIPT_DEBUG', config('app.debug'));
