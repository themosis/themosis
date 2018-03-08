<?php

namespace Themosis\Core;

use Exception;
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
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws Exception
     */
    public function load(array $providers)
    {
        $manifest = $this->loadManifest();

        /*
         * First we will load the service manifest, which contains information on all
         * service providers registered with the application and which services it
         * provides. This is used to know which services are "deferred" loaders.
         */
        if ($this->shouldRecompile($manifest, $providers)) {
            $manifest = $this->compileManifest($providers);
        }

        /*
         * Next, we will register events to load the providers for each of the events
         * that it has requested. This allows the service provider to defer itself
         * while still getting automatically loaded when a certain event occurs.
         */
        foreach ($manifest['when'] as $provider => $events) {
            $this->registerLoadEvents($provider, $events);
        }

        /*
         * We will go ahead and register all of the eagerly loaded providers with the
         * application so their services can be registered with the application as
         * a provided service. Then we will set the deferred service list on it.
         */
        foreach ($manifest['eager'] as $provider) {
            $this->app->register($provider);
        }

        $this->app->addDeferredServices($manifest['deferred']);
    }

    /**
     * Load the service provider manifest file.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return array|null
     */
    public function loadManifest()
    {
        if ($this->files->exists($this->manifestPath)) {
            $manifest = $this->files->getRequire($this->manifestPath);

            if ($manifest) {
                return array_merge(['when' => []], $manifest);
            }
        }
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @param array $manifest
     * @param array $providers
     *
     * @return bool
     */
    public function shouldRecompile($manifest, $providers)
    {
        return is_null($manifest) || $manifest['providers'] !== $providers;
    }

    /**
     * Compile the application service manifest file.
     *
     * @param array $providers
     *
     * @throws Exception
     *
     * @return array
     */
    public function compileManifest($providers)
    {
        /*
         * The service manifest should contain a list of all of the providers for
         * the application so we can compare it on each request to the service
         * and determine if the manifest should be recompiled or is current.
         */
        $manifest = $this->freshManifest($providers);

        foreach ($providers as $provider) {
            $instance = $this->createProvider($provider);

            /*
             * When recompiling the service manifest, we will spin through each of the
             * providers and check if it's a deferred provider or not. If so we'll
             * add it's provided services to the manifest and note the provider.
             */
            if ($instance->isDeferred()) {
                foreach ($instance->provides() as $service) {
                    $manifest['deferred'][$service] = $provider;
                }

                $manifest['when'][$provider] = $instance->when();
            } else {
                /*
                 * If the service providers are not deferred, we will simply add it to an
                 * array of eagerly loaded providers that will get registered on every
                 * request to this application instead of "lazy" loading every time.
                 */
                $manifest['eager'][] = $provider;
            }
        }

        return $this->writeManifest($manifest);
    }

    /**
     * Create a fresh service manifest data structure.
     *
     * @param array $providers
     *
     * @return array
     */
    protected function freshManifest(array $providers)
    {
        return ['providers' => $providers, 'eager' => [], 'deferred' => []];
    }

    /**
     * Write the service manifest file.
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

        return array_merge(['when' => []], $manifest);
    }

    /**
     * Create a new provider instance.
     *
     * @param string $provider
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function createProvider($provider)
    {
        return new $provider($this->app);
    }

    /**
     * Register the load events for the given provider.
     *
     * @param $provider
     * @param array $events
     */
    protected function registerLoadEvents($provider, array $events)
    {
        if (count($events) < 1) {
            return;
        }

        $this->app->make('events')->listen($events, function () use ($provider) {
            $this->app->register($provider);
        });
    }
}
