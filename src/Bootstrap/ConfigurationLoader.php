<?php

namespace Thms\Bootstrap;

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

    public function bootstrap(Application $app)
    {
        $this->app = $app;

        $items = [];

        /*
         * Load configuration repository.
         */
        $app->instance('config', $config = new Repository($items));

        $this->loadConfigurationFiles($app, $config);
    }

    /**
     * Load configuration items from all found config files.
     *
     * @param Application $app
     * @param RepositoryContract $repository
     * @throws Exception
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        $files = $this->getConfigurationFiles($app);

        if (!isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, require $path);
        }
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
     * @param string $path
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
}
