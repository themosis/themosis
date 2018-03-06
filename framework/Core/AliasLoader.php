<?php

namespace Themosis\Core;

class AliasLoader
{
    /**
     * Array of class aliases.
     *
     * @var array
     */
    protected $aliases;

    /**
     * Indicates if a loaded has been registered.
     *
     * @var bool
     */
    protected $registered = false;

    /**
     * @var \Themosis\Core\AliasLoader
     */
    protected static $instance;

    /**
     * The namespace for real-time facades.
     *
     * @var string
     */
    protected static $facadeNamespace = 'Facades\\';

    private function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * Get or create the alias loader singleton.
     *
     * @param array $aliases
     *
     * @return static
     */
    public static function getInstance(array $aliases = [])
    {
        if (is_null(static::$instance)) {
            return static::$instance = new static($aliases);
        }

        $aliases = array_merge(static::$instance->getAliases(), $aliases);

        static::$instance->setAliases($aliases);

        return static::$instance;
    }

    /**
     * Get registered aliases.
     *
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Set aliases.
     *
     * @param array $aliases
     */
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * Register the loader on the auto-loader stack.
     */
    public function register()
    {
        if (! $this->registered) {
            $this->prependToLoaderStack();

            $this->registered = true;
        }
    }

    /**
     * Prepend the load method to the auto-loader stack.
     */
    protected function prependToLoaderStack()
    {
        spl_autoload_register([$this, 'load'], true, true);
    }

    /**
     * Load a class alias if it is registered.
     *
     * @param string $alias
     *
     * @return bool|null
     */
    public function load($alias)
    {
        if (static::$facadeNamespace && strpos($alias, static::$facadeNamespace) === 0) {
            $this->loadFacade($alias);

            return true;
        }

        if (isset($this->aliases[$alias])) {
            return class_alias($this->aliases[$alias], $alias);
        }
    }

    /**
     * Load a real-time facade for the given alias.
     *
     * @param string $alias
     */
    protected function loadFacade($alias)
    {
        require $this->ensureFacadeExists($alias);
    }

    /**
     * Ensure that the given alias has an existing real-time facade class.
     *
     * @param string $alias
     *
     * @return string
     */
    protected function ensureFacadeExists($alias)
    {
        if (file_exists($path = storage_path('framework/cache/facade-'.sha1($alias).'.php'))) {
            return $path;
        }

        file_put_contents($path, $this->formatFacadeStub(
            $alias,
            file_get_contents(__DIR__.'/stubs/facade.stub')
        ));

        return $path;
    }

    /**
     * Format the facade stub with the proper namespace and class.
     *
     * @param string $alias
     * @param string $stub
     *
     * @return string
     */
    protected function formatFacadeStub($alias, $stub)
    {
        $replacements = [
            str_replace('/', '\\', dirname(str_replace('\\', '/', $alias))),
            class_basename($alias),
            substr($alias, strlen(static::$facadeNamespace))
        ];

        return str_replace(
            ['DummyNamespace', 'DummyClass', 'DummyTarget'],
            $replacements,
            $stub
        );
    }

    /**
     * Add an alias to the loader.
     *
     * @param string $class
     * @param string $alias
     */
    public function alias($class, $alias)
    {
        $this->aliases[$class] = $alias;
    }

    /**
     * Indicated if the loader has been registered.
     *
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * Set the registered state of the loader.
     *
     * @param bool $value
     */
    public function setRegistered($value)
    {
        $this->registered = $value;
    }

    /**
     * Set the real-time facade namespace.
     *
     * @param string $namespace
     */
    public static function setFacadeNamespace($namespace)
    {
        static::$facadeNamespace = rtrim($namespace, '\\').'\\';
    }

    /**
     * Set the value of the singleton loader.
     *
     * @param \Themosis\Core\AliasLoader $loader
     */
    public static function setInstance($loader)
    {
        static::$instance = $loader;
    }
}
