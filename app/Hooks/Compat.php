<?php

namespace App\Hooks;

use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Filter;

class Compat extends Hookable
{
    /**
     * @var string
     */
    public $hook = 'deprecated_hook_run';

    /**
     * @var array
     */
    protected $deprecated = [
        'edit_form_after_title',
        'edit_form_advanced'
    ];

    /**
     * Disable WordPress _deprecated messages for deprecated metabox hooks.
     */
    public function register(string $hook)
    {
        if (in_array($hook, $this->deprecated, true)) {
            Filter::add('deprecated_hook_trigger_error', function () {
                return false;
            });
        }
    }
}
