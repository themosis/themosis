<?php

class TestEnvironment extends PHPUnit_Framework_TestCase
{
    /**
     * Test in which environment the application will run.
     */
    public function testWhichEnvironmentDefault()
    {
        $locations = [
            'local' => ['local-hostname', 'another-host', 'team-localhost'],
            'production' => 'prod-hostname',
        ];

        // If nothing is found - Should return empty string.
        $env = new Thms\Config\Environment($locations);
        $this->assertEquals('', $env->which());

        // Simulate local hostname.
        $this->assertEquals('local', $env->which('team-localhost'));
        $this->assertEquals('production', $env->which('prod-hostname'));
    }

    /**
     * Test in which environment the application will run by using a Closure.
     */
    public function testWhichEnvironmentWithClosure()
    {
        $locations = function () {
            return 'local';
        };

        $env = new Thms\Config\Environment($locations);
        $this->assertEquals('local', $env->which('some-host'));

        $locations = function () {
            $host = null;

            if (true) {
                $host = 'local';
            }
        };

        $env = new Thms\Config\Environment($locations);
        $this->assertNotEquals('local', $env->which());
        $this->assertEquals('', $env->which());
    }

    /**
     * Test in which environment the application will run by using string.
     */
    public function testWhichEnvironmentWithString()
    {
        $locations = '';

        $env = new Thms\Config\Environment($locations);
        $this->assertEquals('', $env->which());

        $locations = 'local';

        $env = new \Thms\Config\Environment($locations);
        $this->assertEquals('local', $env->which());
    }
}
