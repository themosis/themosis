<?php
namespace Theme\Providers;

use Theme\Services\Bento\Manifest;
use Themosis\Foundation\ServiceProvider;

class BentoService extends ServiceProvider
{

    /**
     * Register Bento services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('bento.manifest', function () {
            $file = \theme_path("theme.dist", "manifest.json");
            $manifest = json_decode(file_get_contents($file), true);
            return new Manifest($manifest);
        });
    }
}
