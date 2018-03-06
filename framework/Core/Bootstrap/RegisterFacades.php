<?php

namespace Themosis\Core\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Themosis\Core\AliasLoader;
use Themosis\Core\PackageManifest;

class RegisterFacades
{
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance(array_merge(
            $app['config']->get('app.aliases', []),
            $app[PackageManifest::class]->aliases()
        ))->register();
    }
}
