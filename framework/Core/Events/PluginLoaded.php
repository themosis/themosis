<?php

namespace Themosis\Core\Events;

class PluginLoaded
{
    /**
     * Plugin directory name.
     *
     * @var string
     */
    public $directory;

    /**
     * Plugin headers.
     *
     * @var array
     */
    public $headers;

    public function __construct($directory, array $headers)
    {
        $this->directory = $directory;
        $this->headers = $headers;
    }
}
