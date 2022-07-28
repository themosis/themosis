<?php

namespace App\Hooks;

use Themosis\Asset\AssetException;
use Themosis\Core\Support\WordPressUrl;
use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Asset;
use Themosis\Support\Facades\Filter;

class Application extends Hookable
{
    use WordPressUrl;

    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Application locale
        |--------------------------------------------------------------------------
        |
        | Set the application locale based on the WordPress configuration.
        | This overrides the default locale defined in the configuration
        | file config/app.php.
        |
        */
        Action::add('setup_theme', function () {
            $this->app->setLocale(determine_locale());
        });

        /*
        |--------------------------------------------------------------------------
        | Application text domain
        |--------------------------------------------------------------------------
        |
        | Set the application text domain and translations based on the WordPress
        | configuration.
        |
        */
        load_application_textdomain(APP_TD, determine_locale());

        /*
        |--------------------------------------------------------------------------
        | Filter WordPress URLs
        |--------------------------------------------------------------------------
        |
        | The following lines fix core WordPress URLs issues on a multisite
        | installation.
        |
        */
        Filter::add('option_home', function ($url) {
            return $this->formatHomeUrl($url);
        });

        Filter::add('option_siteurl', function ($url) {
            return $this->formatSiteUrl($url);
        });

        Filter::add('network_site_url', function ($url, $path, $scheme) {
            return $this->formatNetworkUrl($url);
        });

        /*
        |--------------------------------------------------------------------------
        | Framework global JS + CSRF
        |--------------------------------------------------------------------------
        |
        | Setup framework global JS variables. Developers can find a global
        | variable "themosisGlobal" in the footer of the WordPress administration.
        | This global variable is always loaded before any registered assets in
        | the footer. A front-end global variable is also available and developers
        | can manage the its name through the "assets" config file.
        |
        */
        Action::add('admin_footer', function () {
            echo $this->app->outputJavascriptGlobal(
                'themosisGlobal',
                apply_filters('themosis_admin_global', [
                    'api' => [
                        'base_url' => home_url('wp-api/themosis/v1/')
                    ]
                ])
            );
        });

        Action::add('wp_head', function () {
            echo $this->app->outputJavascriptGlobal(
                config('assets.ajax.front', 'themosis'),
                apply_filters('themosis_front_global', [
                    'ajaxurl' => admin_url('admin-ajax.php')
                ])
            );

            // CSRF
            if (function_exists('csrf_token')) {
                printf('<meta name="csrf-token" content="%s">', csrf_token());
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Framework core assets
        |--------------------------------------------------------------------------
        |
        | Load the framework core assets. Those assets should be automatically
        | provided during first installation. If those assets are not yet published,
        | you can use the following command from your Console or Terminal:
        | php console vendor:publish --tag=themosis
        |
        */
        try {
            Action::add('admin_enqueue_scripts', function () {
                wp_enqueue_editor();
                wp_enqueue_media();
                wp_enqueue_style('wp-components');
            });
            Asset::add('themosis_core_js', 'js/themosis.core.js', ['lodash', 'wp-tinymce'], $this->app->version())
                ->to('admin');
            Asset::add('themosis_post_status', 'js/themosis.poststatus.js', ['jquery', 'lodash'], $this->app->version())
                ->to('admin');
        } catch (AssetException $e) {
            logger($e->getMessage());
        }
    }
}
