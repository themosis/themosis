<?php

namespace App\Hooks;

use Themosis\Asset\AssetException;
use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Asset;

class Application extends Hookable
{
    /**
     * Set application main logic.
     */
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
            $this->app->setLocale(get_locale());
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
            Asset::add('themosis_core_js', 'js/themosis.core.js', false, $this->app->version())->to('admin');
        } catch (AssetException $e) {
            logger('Themosis Core assets are not published.');
        }
    }
}
