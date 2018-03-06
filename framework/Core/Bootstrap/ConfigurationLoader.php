<?php

namespace Themosis\Core\Bootstrap;

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
         * Verify if configuration is cached. If so, fetch it
         * to avoid parsing all config files.
         */
        if (file_exists($cached = $app->getCachedConfigPath())) {
            $items = require $cached;
            $loadedFromCache = true;
        }

        /*
         * Load configuration repository.
         */
        $app->instance('config', $config = new Repository($items));

        if (! isset($loadedFromCache)) {
            $this->loadConfigurationFiles($app, $config);
        }

        /*
         * Let's set the application environment based on received
         * configuration.
         */
        $app->detectEnvironment(function () use ($config) {
            return $config->get('app.env', 'production');
        });

        /*
         * date_default_timezone_set is set by default to UTC by WordPress.
         */
        mb_internal_encoding($config->get('app.charset'));
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

        $this->loadWordPressConfiguration();
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
     * Load WordPress configuration file.
     *
     * @param string $name
     */
    protected function loadWordPressConfiguration($name = 'wordpress')
    {
        $filename = sprintf('%s.php', $name);

        if (file_exists($file = $this->app->configPath($filename))) {
            require $file;
        }
    }
}
