<?php
namespace Theme\Services\Bento;

use Asset;

class Manifest
{

    protected $manifest;

    /**
     * Create an instance of `Bento`
     *
     * @param string $manifest  Absolute path to the `manifest.json` file
     */
    public function __construct(array $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * Enqueue scripts from `manifest` to Wordpress system
     *
     * @param string $name
     * @return void
     */
    public function add_main_script()
    {
        $name = "main.js";
        $deps = [];

        if (isset($this->manifest["runtime.js"])) {
            $deps[] = "runtime";
            Asset::add("runtime", $this->manifest["runtime.js"], [], '1.0', true);
        }

        if (isset($this->manifest["vendor.js"])) {
            $deps[] = "vendor";
            Asset::add("vendor", $this->manifest["vendor.js"], [], '1.0', true);
        }

        Asset::add(basename($name), $this->manifest[$name], $deps, '1.0', true);
    }

    /**
     * Enqueue styles from `manifest` to Wordpress system
     *
     * @param string $name
     * @return void
     */
    public function add_main_style()
    {
        $name = "main.css";

        if (isset($this->manifest[$name])) {
            Asset::add(basename($name), $this->manifest[$name]);
        }
    }

    /**
     * Return full URL to an asset from Webpack `manifest`
     *
     * @param string $name
     * @return void
     */
    public function asset(string $name)
    {
        if (isset($this->manifest[$name])) {
            return themosis_theme_assets() . $this->manifest[$name];
        }
    }
}
