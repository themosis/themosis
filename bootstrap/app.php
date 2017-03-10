<?php

/*----------------------------------------------------*/
// Paths
/*----------------------------------------------------*/


define( 'THEMOSIS_PROJECT_ROOT_PATH', dirname( __DIR__ ) );
define( 'THEMOSIS_WEB_ROOT_PATH', THEMOSIS_PROJECT_ROOT_PATH . DS . 'htdocs' );


/*----------------------------------------------------*/
// Composer autoload
/*----------------------------------------------------*/
if ( file_exists( $autoload = THEMOSIS_PROJECT_ROOT_PATH . DS . 'vendor' . DS . 'autoload.php' ) ) {
	require_once $autoload;
} else {
	die( 'Unable to find' . DS . ' vendor' . DS . 'autoload.php file in ' . THEMOSIS_PROJECT_ROOT_PATH );
}

/*----------------------------------------------------*/
// Environment configuration
/*----------------------------------------------------*/

/*
 * Load environment
 */
$env = new \Dotenv\Dotenv( THEMOSIS_PROJECT_ROOT_PATH, '.env' );
$env->load();
$env->required( [ 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'WP_HOME', 'WP_SITEURL' ] );

/*
 * Include shared WordPress configuration (constants)
 */
if ( file_exists( $shared = THEMOSIS_PROJECT_ROOT_PATH . DS . 'config' . DS . 'wordpress' . DS . 'constants.php' ) ) {
	require_once $shared;
}

/*
 * Define additional environment file if needed
 */
$additional_environment_file = env( 'APP_ENV', 'local' );

/*
 * Load additional environment configuration
 */
if ( file_exists( $config = THEMOSIS_PROJECT_ROOT_PATH . DS . 'config' . DS . 'environments' . DS . $additional_environment_file . '.php' ) ) {
	require_once $config;
}

/*----------------------------------------------------*/
// Constants
/*----------------------------------------------------*/
define( 'THEMOSIS_STORAGE', THEMOSIS_PROJECT_ROOT_PATH . DS . 'storage' );
define( 'CONTENT_DIR', 'content' );
define( 'WP_CONTENT_DIR', THEMOSIS_WEB_ROOT_PATH . DS . CONTENT_DIR );
define( 'WP_CONTENT_URL', WP_HOME . '/' . CONTENT_DIR );


/*----------------------------------------------------*/
// Error handling
/*----------------------------------------------------*/
if ( env( 'APP_DEBUG' ) ) {
	$whoops = new \Whoops\Run();
	$whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler() );
	$whoops->register();
}

/*----------------------------------------------------*/
// Preparing ended.
// See You after Themosis Framework will be loaded from directory mu-plugins
/*----------------------------------------------------*/
