<?php

use Illuminate\Filesystem\Filesystem;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Themosis\Core\Application;
use Themosis\Core\PluginsRepository;

class PluginsLoaderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testLoadManifestWhenNoFileExists()
    {
        $app = Mockery::mock('Themosis\Core\Application');
        $filesystem = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $loader = new PluginsRepository($app, $filesystem, '', 'plugins.php');

        $filesystem->shouldReceive('exists')->once();
        $this->assertNull($loader->loadManifest());
    }

    public function testLoadManifestWhenFileExists()
    {
        $app = Mockery::mock('Themosis\Core\Application');
        $filesystem = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $loader = new PluginsRepository(
            $app,
            $filesystem,
            '',
            ''
        );

        $plugins = ['fake-plugin' => [
            'root' => 'fakefile.php',
            'name' => 'Fake Plugin',
            'plugin_uri' => '',
            'version' => '',
            'description' => '',
            'author' => '',
            'author_uri' => '',
            'textdomain' => '',
            'domainpath' => '',
            'network' => ''
        ]];

        $filesystem->shouldReceive('exists')->once()->andReturnTrue();
        $filesystem->shouldReceive('getRequire')->once()->andReturn($plugins);

        $manifest = $loader->loadManifest();
        $this->assertTrue(is_array($manifest));
        $this->assertEquals($plugins, $manifest);
    }

    public function testLoaderCanGetPluginHeader()
    {
        $app = Mockery::mock('Themosis\Core\Application');
        $filesystem = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $loader = new PluginsRepository(
            $app,
            $filesystem,
            '',
            ''
        );

        $headers = $loader->getPluginHeaders(
            realpath(__DIR__.'/../htdocstest/content/mu-plugins/fake-plugin/fakeplugin.php')
        );

        $this->assertTrue(is_array($headers));
        $this->assertEquals([
            'name' => 'Fake Plugin',
            'plugin_uri' => 'https://framework.themosis.com',
            'version' => '1.0.0',
            'description' => 'A fake plugin used for testing purpose only.',
            'author' => 'Fake Author',
            'author_uri' => '',
            'textdomain' => '',
            'domainpath' => '',
            'network' => ''
        ], $headers);
    }

    public function testLoaderCanGetThePluginWithHeaders()
    {
        $loader = new PluginsRepository(
            Application::getInstance(),
            new Filesystem(),
            realpath(__DIR__.'/../htdocstest/content/mu-plugins'),
            ''
        );

        $allHeaders = $loader->getPlugin('fake-plugin');
        $expected = [
            'root' => 'fakeplugin.php',
            'name' => 'Fake Plugin',
            'plugin_uri' => 'https://framework.themosis.com',
            'version' => '1.0.0',
            'description' => 'A fake plugin used for testing purpose only.',
            'author' => 'Fake Author',
            'author_uri' => '',
            'textdomain' => '',
            'domainpath' => '',
            'network' => ''
        ];
        $this->assertTrue(is_array($allHeaders));
        $this->assertEquals($expected, $allHeaders);
    }
}
