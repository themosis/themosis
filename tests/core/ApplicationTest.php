<?php

use Thms\Core\Application;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testBasePathSetup()
    {
        $app = new Application(realpath(__DIR__.'/../../'));

        $this->assertEquals('/home/vagrant/code', $app->basePath());
    }
}
