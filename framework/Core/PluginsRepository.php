<?php

namespace Themosis\Core;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;

class PluginsRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $pluginsPath;

    /**
     * @var string
     */
    protected $manifestPath;

    public function __construct(Application $application, Filesystem $files, string $pluginsPath, string $manifestPath)
    {
        $this->app = $application;
        $this->files = $files;
        $this->pluginsPath = $pluginsPath;
        $this->manifestPath = $manifestPath;
    }

    public function load()
    {
        $manifest = $this->loadManifest();
    }

    /**
     * Return plugins manifest.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return mixed|null
     */
    protected function loadManifest()
    {
        if ($this->files->exists($this->manifestPath)) {
            return $this->files->getRequire($this->manifestPath);
        }

        return null;
    }
}
