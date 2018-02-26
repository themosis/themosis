<?php

namespace Thms\Core;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;

class ProviderRepository
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
    protected $manifestPath;

    public function __construct(Application $app, Filesystem $files, $manifestPath)
    {
        $this->app = $app;
        $this->files = $files;
        $this->manifestPath = $manifestPath;
    }

    /**
     * Register application service providers.
     *
     * @param array $providers
     */
    public function load(array $providers)
    {
        // TODO: load service providers.
    }
}
