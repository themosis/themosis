<?php

namespace Thms\Config;

use Closure;

class Environment
{
    /**
     * Environment locations.
     *
     * @var array|Closure
     */
    protected $locations = [];

    /**
     * Init the Environment class.
     *
     * @param array|Closure $locations Environment locations - Detection.
     */
    public function __construct($locations)
    {
        $this->locations = $locations;
    }

    /**
     * Find in which environment we are.
     *
     * @param string $hostname The hostname to compare with.
     *
     * @return string
     */
    public function which($hostname = '')
    {
        // Check if $locations is a closure.
        // This means we're checking for environment variables through the closure.
        if ($this->locations instanceof Closure) {
            $callback = $this->locations;

            return $callback();
        }

        // If not using closure, we're using the default detection
        // by comparing the given hostnames from an array.
        if (is_array($this->locations) && !empty($this->locations)) {
            foreach ($this->locations as $location => $host) {
                $host = is_array($host) ? $host : [$host];
                if (in_array($hostname, $host)) {
                    return $location;
                }
            }
        }

        // If not using array, a single string is provided to define the
        // environment.
        if (is_string($this->locations)) {
            return $this->locations;
        }

        return '';
    }
}
