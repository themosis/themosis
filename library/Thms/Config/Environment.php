<?php
namespace Thms\Config;

use Closure;

class Environment
{
    /**
	 * Root path where files are located.
	 *
	 * @var string
	 */
    protected $path;

    /**
	 * Environments locations.
	 *
	 * @var array
	 */
    protected $locations = array();

    /**
     * Use closure for environment detection
     *
     * @var boolean
     */
    protected $closure = false;

    /**
	 * Init the Environment class.
	 *
	 * @param string $path The root path where environments files are located.
	 * @param array $locations Environments locations: 'local' - 'production'... and hostnames.
	 */
    public function __construct($path, $locations)
    {
        $this->path = $path;
        $this->locations = $locations;

        if ($locations instanceof Closure) {
        	$this->closure = true;
        }
    }

    /**
	 * Find which environment we are.
	 *
	 * @return string
	 */
    public function which()
    {
    	if ($this->closure) {
    		$environment = $this->locations;
    		return $environment();
    	}

        $hostname = gethostname();

        foreach ($this->locations as $location => $name) {
            if ($hostname === $name) {
                return $location;
            }
        }

        return '';
    }

    /**
	 * Load the .env.{$location}.php file.
	 *
	 * @param string $location
	 * @return array
	 */
    public function load($location)
    {
        if (file_exists($path = $this->getFile($location))) {
            return require_once $path;
        }

        return array();
    }

    /**
	 * Check required values.
	 *
	 * @param array $required The required values to check.
	 * @param array $values
	 * @return bool
	 */
    public function check(array $required, array $values)
    {
        foreach ($required as $key) {
            if (!array_key_exists($key, $values)) {
                return false;
            }
        }

        return true;
    }

    /**
	 * Populate environment vars.
	 *
	 * @param array $vars The loaded environments vars.
	 * @return void
	 */
    public function populate(array $vars)
    {
        foreach ($vars as $key => $value) {
            if (false === getenv($key)) {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }

    /**
	 * Return the .env file path.
	 *
	 * @param string $location
	 * @return string
	 */
    protected function getFile($location)
    {
        return $this->path.'.env.'.$location.'.php';
    }
}
