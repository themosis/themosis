<?php

namespace Thms\Core\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Thms\Core\PackageManifest;

class RegisterFacades
{
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        // TODO: Implement alias loader.
        $aliases = $app[PackageManifest::class]->aliases();
    }
}
