<?php

namespace Thms\Core;

use Illuminate\Filesystem\Filesystem;

class PackageManifest
{
    /**
     * @var Filesystem
     */
    public $files;

    /**
     * @var string
     */
    public $basePath;

    /**
     * @var string
     */
    public $manifestPath;

    /**
     * @var string
     */
    public $vendorPath;

    /**
     * @var array
     */
    public $manifest;

    public function __construct(Filesystem $files, $basePath, $manifestPath)
    {
        $this->files = $files;
        $this->basePath = $basePath;
        $this->manifestPath = $manifestPath;
        $this->vendorPath = $basePath.'/vendor';
    }
}
