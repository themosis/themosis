<?php

use PHPUnit\Framework\TestCase;
use Themosis\Core\Application;

class ApplicationTest extends TestCase
{
    public function testBasePathSetup()
    {
        $path = realpath(__DIR__.'/../../');
        $app = new Application($path);
        $this->assertEquals($path, $app->basePath());
    }

    public function testApplicationPaths()
    {
        $path = realpath(__DIR__.'/../');
        $app = new Application($path);

        $this->assertEquals(
            $path.'/app',
            $app['path'],
            'Cannot get the default path'
        );
        $this->assertEquals(
            $path,
            $app['path.base'],
            'Cannot get the base path'
        );
        $this->assertEquals(
            $path.'/htdocstest/content',
            $app['path.content'],
            'Cannot get the content path'
        );
        $this->assertEquals(
            $path.'/htdocstest/content/mu-plugins',
            $app['path.muplugins'],
            'Cannot get the mu-plugins path'
        );
        $this->assertEquals(
            $path.'/htdocstest/content/plugins',
            $app['path.plugins'],
            'Cannot get the plugins path'
        );
        $this->assertEquals(
            $path.'/htdocstest/content/themes',
            $app['path.themes'],
            'Cannot get the themes path'
        );
        $this->assertEquals(
            $path.'/app',
            $app['path.application'],
            'Cannot get the app path'
        );
        $this->assertEquals(
            $path.'/htdocstest/content/languages',
            $app['path.lang'],
            'Cannot get the languages path'
        );
        $this->assertEquals(
            $path.'/htdocstest',
            $app['path.web'],
            'Cannot get the web path'
        );
        $this->assertEquals(
            $path,
            $app['path.root'],
            'Cannot get the root path'
        );
        $this->assertEquals(
            $path.'/config',
            $app['path.config'],
            'Cannot get the defaut config path'
        );
        $this->assertEquals(
            $path.'/htdocstest',
            $app['path.public'],
            'Cannot get the public path'
        );
        $this->assertEquals(
            $path.'/storage',
            $app['path.storage'],
            'Cannot get the storage path'
        );
        $this->assertEquals(
            $path.'/database',
            $app['path.database'],
            'Cannot get the database path'
        );
        $this->assertEquals(
            $path.'/bootstrap',
            $app['path.bootstrap'],
            'Cannot get the bootstrap path'
        );
    }
}
