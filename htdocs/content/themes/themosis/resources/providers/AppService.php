<?php

namespace Theme\Providers;

use Themosis\Foundation\ServiceProvider;

class AppService extends ServiceProvider
{

    /**
     * Add more configuration for convenience sake
     *
     * @return void
     */
    public function register()
    {
        themosis_set_paths([
            "theme.dist" => realpath(themosis_path("theme") . "/dist"),
        ]);
    }
}
