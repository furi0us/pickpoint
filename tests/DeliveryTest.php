<?php
namespace Domatskiy\Tests;

use Domatskiy\PickPoint;
use Domatskiy\PickPoint\Type;

class DeliveryTest extends \PHPUnit_Framework_TestCase
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
        $CPicPoint = new PickPoint($this->config_is_test);
        $CPicPoint->login($this->config_login, $this->config_passw);

        $rsLogin = $CPicPoint->login();

        $this->assertEquals($rsLogin instanceof Type\Auth, true);


        $rsCityList = $CPicPoint->directory()->citylist();
        $this->assertEquals($rsCityList instanceof Type\CityList, true);
        $city = current($rsCityList->data);
        print_r($city->Id);


        $rsPostomat = $CPicPoint->directory()->postamatlist();
        $this->assertEquals($rsPostomat instanceof Type\PostomatList, true);
        $postomat = current($rsPostomat->data);
        print_r($postomat->Id.' '.$postomat->PostCode);

        $rsZone = $CPicPoint->delivery()->getzone($city->Id, $postomat->PostCode);
        $this->assertEquals($rsZone instanceof Type\ZoneList, true);

        $zone = current($rsZone->data);


    }

}
