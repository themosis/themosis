<?php

namespace Themosis\Core;

use Exception;
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

    /**
     * Get aliases of all the packages.
     *
     * @return array
     */
    public function aliases()
    {
        return $this->get();
    }

    /**
     * Get providers of all the packages.
     *
     * @return array
     */
    public function providers()
    {
        return $this->get('providers');
    }

    /**
     * Get manifest items by key.
     *
     * @param string $key
     *
     * @return array
     */
    public function get($key = 'aliases')
    {
        return collect($this->getManifest())->flatMap(function ($configuration) use ($key) {
            return (array) ($configuration[$key] ?? []);
        })->filter()->all();
    }

    /**
     * Get the current packages manifest.
     *
     * @return array
     */
    protected function getManifest()
    {
        if (! is_null($this->manifest)) {
            return $this->manifest;
        }

        if (! file_exists($this->manifestPath)) {
            $this->build();
        }
    }

    /**
     * Generate the packages.php manifest file.
     */
    protected function build()
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath.'/composer/installed.json')) {
            $packages = json_decode($this->files->get($path), true);
        }

        $ignoreAll = in_array('*', $ignore = $this->packagesToIgnore());

        $this->write(collect($packages)->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['laravel'] ?? []];
        })->each(function ($configuration) use (&$ignore) {
            $ignore = array_merge($ignore, $configuration['dont-discover'] ?? []);
        })->reject(function ($configuration, $package) use ($ignore, $ignoreAll) {
            return $ignoreAll || in_array($package, $ignore);
        })->filter()->all());
    }

    /**
     * Get all the packages names to be ignored.
     *
     * @return array
     */
    protected function packagesToIgnore()
    {
        if (! file_exists($this->basePath.'/composer.json')) {
            return [];
        }

        return json_decode(
            file_get_contents($this->basePath.'/composer.json'),
            true
        )['extra']['laravel']['dont-discover'] ?? [];
    }

    /**
     * Format given package name.
     *
     * @param string $package
     *
     * @return string
     */
    protected function format($package)
    {
        return str_replace($this->vendorPath.'/', '', $package);
    }

    /**
     * Write the given manifest to disk.
     *
     * @param array $manifest
     *
     * @throws Exception
     */
    protected function write(array $manifest)
    {
        if (! is_writable(dirname($this->manifestPath))) {
            throw new Exception('The '.dirname($this->manifestPath).' directory must be present and writable.');
        }

        $this->files->put(
            $this->manifestPath,
            '<?php return '.var_export($manifest, true).';'
        );
    }
}
