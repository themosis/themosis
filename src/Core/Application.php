<?php

namespace Thms\Core;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Application extends Container implements ApplicationContract, HttpKernelInterface
{
    /**
     * Application version.
     *
     * @var string
     */
    const VERSION = '1.4.0';

    /**
     * Base path of the framework.
     *
     * @var string
     */
    protected $basePath;

    /**
     * The deferred services and their providers.
     *
     * @var array
     */
    protected $deferredServices = [];

    /**
     * All of the registered service providers.
     *
     * @var array
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * Indicates if the application has booted.
     *
     * @var bool
     */
    protected $booted = false;

    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
        $this->registerCoreContainerAliases();
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Register basic bindings into the container.
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(Container::class, $this);
    }

    /**
     * Register base service providers.
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new LogServiceProvider($this));
    }

    protected function registerCoreContainerAliases()
    {
        $list = [
            'app' => [
                Application::class,
                \Illuminate\Contracts\Container\Container::class,
                \Illuminate\Contracts\Foundation\Application::class,
                \Psr\Container\ContainerInterface::class
            ]
        ];

        foreach ($list as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @param string $path Optional path to append to the base path.
     *
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        // Core
        $this->instance('path', $this->path());
        // Base
        $this->instance('path.base', $this->basePath());
        // Content
        $this->instance('path.content', $this->contentPath());
        // Mu-plugins
        $this->instance('path.muplugins', $this->mupluginsPath());
        // Plugins
        $this->instance('path.plugins', $this->pluginsPath());
        // Themes
        $this->instance('path.themes', $this->themesPath());
        // Application
        $this->instance('path.application', $this->applicationPath());
        // Resources
        $this->instance('path.resources', $this->resourcePath());
        // Languages
        $this->instance('path.lang', $this->langPath());
        // Web root
        $this->instance('path.web', $this->webPath());
        // Root
        $this->instance('path.root', $this->rootPath());
        // Config
        $this->instance('path.config', $this->configPath());
        // Public
        $this->instance('path.public', $this->webPath());
        // Storage
        $this->instance('path.storage', $this->storagePath());
        // Database
        $this->instance('path.database', $this->databasePath());
        // Bootstrap
        $this->instance('path.bootstrap', $this->bootstrapPath());
    }

    /**
     * Get the path to the application "themosis-application" directory.
     *
     * @param string $path
     * @return string
     */
    public function path($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'themosis-framework'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the WordPress "content" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function contentPath($path = '')
    {
        return WP_CONTENT_DIR.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the WordPress "mu-plugins" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function mupluginsPath($path = '')
    {
        return $this->basePath($path);
    }

    /**
     * Get the WordPress "plugins" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function pluginsPath($path = '')
    {
        return $this->contentPath('plugins').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the WordPress "themes" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function themesPath($path = '')
    {
        return $this->contentPath('themes').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the application directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function applicationPath($path = '')
    {
        return $this->mupluginsPath('themosis-application').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the application "resources" directory.
     *
     * @param string $path
     * @return string
     */
    public function resourcePath($path = '')
    {
        return $this->applicationPath('resources').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the WordPress "languages" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function langPath($path = '')
    {
        return $this->contentPath('languages').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path of the web server root.
     *
     * @param string $path
     *
     * @return string
     */
    public function webPath($path = '')
    {
        //return rtrim(ABSPATH, '\/').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the root path of the project.
     *
     * @param string $path
     *
     * @return string
     */
    public function rootPath($path = '')
    {
        if (defined('THEMOSIS_ROOT')) {
            return THEMOSIS_ROOT.($path ? DIRECTORY_SEPARATOR.$path : $path);
        }

        return $this->webPath($path);
    }

    /**
     * Get the main application plugin configuration directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->resourcePath('config').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the storage directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function storagePath($path = '')
    {
        if (defined('THEMOSIS_ROOT')) {
            return $this->rootPath('storage').($path ? DIRECTORY_SEPARATOR.$path : $path);
        }

        return $this->contentPath('storage').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the database directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function databasePath($path = '')
    {
        return $this->rootPath('data').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function bootstrapPath($path = '')
    {
        if (defined('THEMOSIS_ROOT')) {
            return $this->rootPath('bootstrap').($path ? DIRECTORY_SEPARATOR.$path : $path);
        }

        return $this->applicationPath('bootstrap').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get or check the current application environment.
     *
     * @return string|bool
     */
    public function environment()
    {
        if (func_num_args() > 0) {
            $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            foreach ($patterns as $pattern) {
                if (Str::is($pattern, $this['env'])) {
                    return true;
                }
            }

            return false;
        }

        return $this['env'];
    }

    /**
     * Determine if we are running in the console.
     *
     * @return bool
     */
    public function runningInConsole()
    {
        return php_sapi_name() == 'cli' || php_sapi_name() == 'phpdbg';
    }

    /**
     * Determine if the application is currently down for maintenance.
     *
     * @return bool
     */
    public function isDownForMaintenance()
    {
        return file_exists(ABSPATH.'.maintenance') || wp_installing();
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        // TODO: Implement registerConfiguredProviders() method.
    }

    /**
     * Register a deferred provider and service.
     *
     * @param  string $provider
     * @param  string|null $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        if ($service) {
            unset($this->deferredServices[$service]);
        }

        $this->register($instance = new $provider($this));

        if (!$this->booted) {
            $this->booting(function () use ($instance) {
                $this->bootProvider($instance);
            });
        }
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * Boot the given service provider.
     *
     * @param ServiceProvider $provider
     *
     * @return mixed
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }

    /**
     * Register a new boot listener.
     *
     * @param  mixed $callback
     * @return void
     */
    public function booting($callback)
    {
        // TODO: Implement booting() method.
    }

    /**
     * Register a new "booted" listener.
     *
     * @param  mixed $callback
     * @return void
     */
    public function booted($callback)
    {
        // TODO: Implement booted() method.
    }

    /**
     * Get the path to the cached services.php file.
     *
     * @return string
     */
    public function getCachedServicesPath()
    {
        // TODO: Implement getCachedServicesPath() method.
    }

    /**
     * Get the path to the cached packages.php file.
     *
     * @return string
     */
    public function getCachedPackagesPath()
    {
        // TODO: Implement getCachedPackagesPath() method.
    }

    /**
     * Handles a Request to convert it to a Response.
     *
     * When $catch is true, the implementation must catch all exceptions
     * and do its best to convert them to a Response instance.
     *
     * @param Request $request A Request instance
     * @param int $type The type of the request
     *                         (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
     * @param bool $catch Whether to catch exceptions or not
     *
     * @return Response A Response instance
     *
     * @throws \Exception When an Exception occurs during processing
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        // TODO: Implement handle() method.
    }

    /**
     * Register a service provider with the application.
     *
     * @param  \Illuminate\Support\ServiceProvider|string $provider
     * @param  array $options
     * @param  bool $force
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register($provider, $options = [], $force = false)
    {
        if (($registered = $this->getProvider($provider)) && !$force) {
            return $registered;
        }

        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by this developer's application logic.
        if ($this->booted) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    /**
     * Get the registered service provider instance if it exists.
     *
     * @param ServiceProvider|string $provider
     *
     * @return ServiceProvider|null
     */
    public function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    /**
     * Get the registered service provider instances if any exist.
     *
     * @param ServiceProvider|string $provider
     *
     * @return array
     */
    public function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::where($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    /**
     * Resolve a service provider instance from the class name.
     *
     * @param string $provider
     *
     * @return ServiceProvider
     */
    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    /**
     * Mark the given provider as registered.
     *
     * @param ServiceProvider $provider
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;
        $this->loadedProviders[get_class($provider)] = true;
    }

    /**
     * Determine if the application is running unit tests.
     *
     * @return bool
     */
    public function runningUnitTests()
    {
        // TODO: Implement runningUnitTests() method.
    }
}
