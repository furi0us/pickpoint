<?php
namespace Domatskiy\Tests;

use Domatskiy\PickPoint;

class LoginTest extends \PHPUnit_Framework_TestCase
{
    private $config_is_test = null,
            $config_login = null,
            $config_passw = null;

    public function setUp()
    {
        $reader = new \Piwik\Ini\IniReader();
        $config = $reader->readFile(__DIR__.'/config.ini');

        $this->config_is_test = isset($config['test']) && (int)$config['test'] == 1;
        $this->config_login = isset($config['login']) ? $config['login'] : '';
        $this->config_passw = isset($config['passw']) ? $config['passw'] : '';

        echo "\n";
        echo 'auth with login:'.$this->config_login.', passw:'.$this->config_passw.', $is_test='.$this->config_is_test;
        echo "\n";
    }

    public function tearDown()
    {

    }

    public function test()
    {

        $CPicPoint = new PickPoint(null, $this->config_is_test);
        $CPicPoint->login($this->config_login, $this->config_passw);

        $result = $CPicPoint->login();
        $this->assertEquals($result instanceof PickPoint\Type\Type, true);

        echo 'SessionId: '.$result->SessionId;

    }

}
