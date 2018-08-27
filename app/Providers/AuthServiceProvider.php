<?php

namespace App\Providers;

use Themosis\Core\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy'
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
