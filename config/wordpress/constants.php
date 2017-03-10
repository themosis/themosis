<?php

/*----------------------------------------------------*/
// All Constants that we can define in Wordpress
/*----------------------------------------------------*/
// Database
define( 'DB_NAME',              env( 'DB_NAME' ) );
define( 'DB_USER',              env( 'DB_USER' ) );
define( 'DB_PASSWORD',          env( 'DB_PASSWORD' ) );
define( 'DB_HOST',              env( 'DB_HOST', 'localhost' ) );
define( 'DB_CHARSET',           env( 'DB_CHARSET', 'utf8mb4' ) );
define( 'DB_COLLATE',           env( 'DB_COLLATE', 'utf8mb4_unicode_ci' ) );

$table_prefix =                 env( 'DB_PREFIX', 'wp_' );

// WordPress URLs
define( 'WP_HOME',              env( 'WP_HOME' ) );
define( 'WP_SITEURL',           env( 'WP_SITEURL' ) );

// Jetpack
define( 'JETPACK_DEV_DEBUG',    env( 'APP_DEBUG' ) );

// Encoding
define( 'THEMOSIS_CHARSET',     env( 'THEMOSIS_CHARSET', 'UTF-8' ) );

// Development
define( 'SAVEQUERIES',          env( 'APP_DEBUG' ) );
define( 'WP_DEBUG',             env( 'APP_DEBUG' ) );
define( 'WP_DEBUG_DISPLAY',     env( 'APP_DEBUG' ) );
define( 'SCRIPT_DEBUG',         env( 'APP_DEBUG' ) );

// Themosis framework
define( 'THEMOSIS_ERROR',       env( 'APP_DEBUG' ) );
define( 'BS',                   env( 'APP_DEBUG' ) );

/*----------------------------------------------------*/
// Authentication unique keys and salts
/*----------------------------------------------------*/
/*
 * @link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service
 */
define( 'AUTH_KEY',             env( 'AUTH_KEY' ) );
define( 'AUTH_SALT',            env( 'AUTH_SALT' ) );
define( 'NONCE_KEY',            env( 'NONCE_KEY' ) );
define( 'NONCE_SALT',           env( 'NONCE_SALT' ) );
define( 'LOGGED_IN_KEY',        env( 'LOGGED_IN_KEY' ) );
define( 'LOGGED_IN_SALT',       env( 'LOGGED_IN_SALT' ) );
define( 'SECURE_AUTH_KEY',      env( 'SECURE_AUTH_KEY' ) );
define( 'SECURE_AUTH_SALT',     env( 'SECURE_AUTH_SALT' ) );

/*----------------------------------------------------*/
// Custom settings
/*----------------------------------------------------*/
define( 'WP_AUTO_UPDATE_CORE',  env( 'WP_AUTO_UPDATE_CORE', false ) );
define( 'DISALLOW_FILE_EDIT',   env( 'DISALLOW_FILE_EDIT', true ) );
define( 'WP_DEFAULT_THEME',     env( 'WP_DEFAULT_THEME', 'themosis-theme' ) );

/* That's all, stop editing! Happy blogging. */
