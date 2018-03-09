<?php

namespace Themosis\Core;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Themosis\Core\Events\PluginLoaded;

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

    /**
     * Plugin headers.
     *
     * @var array
     */
    protected $headers = [
        'name' => 'Plugin Name',
        'plugin_uri' => 'Plugin URI',
        'version' => 'Version',
        'description' => 'Description',
        'author' => 'Author',
        'author_uri' => 'Author URI',
        'textdomain' => 'Text Domain',
        'domainpath' => 'Domain Path',
        'network' => 'Network'
    ];

    public function __construct(Application $application, Filesystem $files, string $pluginsPath, string $manifestPath)
    {
        $this->app = $application;
        $this->files = $files;
        $this->pluginsPath = $pluginsPath;
        $this->manifestPath = $manifestPath;
    }

    /**
     * Load application must-use plugins.
     *
     * @param array $directories
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws Exception
     */
    public function load(array $directories)
    {
        $manifest = $this->loadManifest();

        if ($this->shouldRecompile($manifest, $directories)) {
            $manifest = $this->compileManifest($directories);
        }

        // Load plugins defined in the manifest.
        // Dispatch an event with loaded plugin data.
        foreach ($manifest as $plugin => $headers) {
            $path = sprintf('%s/%s', $plugin, $headers['root']);
            $this->app->registerPlugin($path);
            $this->app['events']->dispatch(
                new PluginLoaded($plugin, $headers)
            );
        }
    }

    /**
     * Compile a new plugin manifest.
     *
     * @param array $directories
     *
     * @throws Exception
     *
     * @return array
     */
    public function compileManifest(array $directories)
    {
        $manifest = [];

        foreach ($directories as $directory) {
            // Find the root file of each plugin.
            // As we load the plugins from the mu-plugins directory
            // we do not need to get their header. Only the file
            // that defines them.
            $manifest[$directory] = $this->getPlugin($directory);
        }

        return $this->writeManifest($manifest);
    }

    /**
     * Get the plugin. Find the root file and return its headers.
     *
     * @param string $directory
     *
     * @return array
     */
    public function getPlugin(string $directory)
    {
        $files = $this->files->files($this->app->mupluginsPath($directory));

        foreach ($files as $file) {
            $headers = $this->getPluginHeaders($file->getRealPath());

            if (! empty($headers['name'])) {
                return array_merge(['root' => $file->getFilename()], $headers);
                break;
            }
        }
    }

    /**
     * Retrieve file headers if any.
     *
     * @param string $path
     *
     * @return array
     *
     * @see get_file_data() located in wp-includes/functions.php for more information.
     */
    public function getPluginHeaders(string $path): array
    {
        $data = $this->getFileContent($path);
        $headers = [];

        foreach ($this->headers as $field => $regex) {
            if (preg_match('/^[ \t\/*#@]*'.preg_quote($regex, '/').':(.*)$/mi', $data, $match) && $match[1]) {
                $headers[$field] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
            } else {
                $headers[$field] = '';
            }
        }

        return $headers;
    }

    /**
     * Get a partial content of given file.
     *
     * @param string $path
     * @param int    $length
     *
     * @return string
     */
    public function getFileContent(string $path, int $length = 8192): string
    {
        $handle = fopen($path, 'r');
        $content = fread($handle, $length);
        fclose($handle);

        return str_replace("\r", "\n", $content);
    }

    /**
     * Verify if the plugins manifest should be recompiled.
     *
     * @param array|null $manifest
     * @param array      $directories
     *
     * @return bool
     */
    public function shouldRecompile($manifest, $directories)
    {
        return is_null($manifest) || array_keys($manifest) !== $directories;
    }

    /**
     * Return plugins manifest.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return array|null
     */
    public function loadManifest()
    {
        if ($this->files->exists($this->manifestPath)) {
            return $this->files->getRequire($this->manifestPath);
        }

        return null;
    }

    /**
     * Write the plugins manifest file.
     *
     * @param array $manifest
     *
     * @throws Exception
     *
     * @return array
     */
    public function writeManifest(array $manifest)
    {
        if (! is_writable(dirname($this->manifestPath))) {
            throw new Exception('The bootstrap/cache directory must be present and writable.');
        }

        $this->files->put(
            $this->manifestPath,
            '<?php return '.var_export($manifest, true).';'
        );

        return $manifest;
    }
}
