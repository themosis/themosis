<?php

use PHPUnit\Framework\TestCase;
use Themosis\Core\Application;

class ApplicationTest extends TestCase
{
    public function testBasePathSetup()
    {
        $path = realpath(__DIR__.'/../../');
        $app = new Application(realpath($path));
        $this->assertEquals($path, $app->basePath());
    }
}
