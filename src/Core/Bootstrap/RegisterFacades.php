<?php

namespace Thms\Core\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Thms\Core\AliasLoader;
use Thms\Core\PackageManifest;

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
