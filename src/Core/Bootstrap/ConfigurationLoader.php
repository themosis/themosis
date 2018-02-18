<?php

namespace Thms\Core\Bootstrap;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Finder\Finder;

class ConfigurationLoader
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * WordPress  directory name.
     *
     * @var string
     */
    protected $dir = 'wordpress';

    public function bootstrap(Application $app)
    {
        $this->app = $app;

        $items = [];

        /*
         * Load configuration repository.
         */
        $app->instance('config', $config = new Repository($items));

        // TODO: Implement environment detector configuration

        $this->loadConfigurationFiles($app, $config);
    }

    /**
     * Load configuration items from all found config files.
     *
     * @param Application        $app
     * @param RepositoryContract $repository
     *
     * @throws Exception
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        $files = $this->getConfigurationFiles($app);

        if (! isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, require $path);
        }

        $this->loadWordPressConfiguration(env('APP_ENV', 'production'));
    }

    /**
     * Get all configuration files.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];

        foreach (Finder::create()->files()->name('*.php')->in($app->configPath()) as $file) {
            $directory = $this->getNestedDirectory($file, $app->configPath());

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Get configuration file nesting path.
     *
     * @param \SplFileInfo $file
     * @param string       $path
     *
     * @return string
     */
    protected function getNestedDirectory(\SplFileInfo $file, $path)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($path, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
    }

    /**
     * Load WordPress configuration files.
     *
     * @param string $location
     */
    protected function loadWordPressConfiguration($location = 'production')
    {
        $path = sprintf('%s/locations/%s.php', $this->dir, $location);

        /*
         * Load WordPress configuration file. Ex.: local.php
         */
        if (file_exists($file = $this->app->configPath($path))) {
            require_once $file;
        }

        /*
         * Load shared environment configuration file shared.php
         */
        if (file_exists($sharedFile = $this->app->configPath($this->dir.'/shared.php'))) {
            require_once $sharedFile;
        }
    }
}
