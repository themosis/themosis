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

                /*
                 * Test against an array of hosts.
                 */
                if (is_array($host)) {
                    foreach ($host as $h) {
                        if ($this->match($h, $hostname)) {
                            return $location;
                        }
                    }
                } else {
                    /*
                     * Test against a string/regular expression.
                     */
                    if ($this->match($host, $hostname)) {
                        return $location;
                    }
                }
            }
        }

        // If not using array, a single string is provided to define the
        // environment.
        if (is_string($this->locations)) {

            // Default string.
            return $this->locations;
        }

        return '';
    }

    /**
     * Check if a host is matching a pattern.
     *
     * @param string $host The regular expression pattern host to use.
     * @param string $hostname The host name.
     *
     * @return bool
     */
    protected function match($host, $hostname)
    {
        $pattern = ($host !== '/') ? str_replace('*', '(.*)', $host).'\z' : '^/$';
        return (bool) preg_match('/'.$pattern.'/', $hostname);
    }
}
