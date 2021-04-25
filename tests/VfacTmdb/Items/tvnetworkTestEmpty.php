<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class TvNetworkTest extends TestCase
{
    protected $tmdb       = null;
    protected $network    = null;
    protected $network_id = 1;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVNetworkOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestTvNetworkEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVNetworkEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVNetworkOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testContructFailure()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new TVNetwork($this->tmdb, $this->network_id);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEquals('Fuji TV', $network->getName());
    }

    /**
     * @test
     */
    public function testGetNameFailure()
    {
        $this->setRequestTvNetworkEmpty();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEmpty($network->getName());
    }

    /**
     * @test
     */
    public function testGetHeadquarters()
    {
        $this->setRequestOk();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEquals('Minato, Tokyo Prefecture', $network->getHeadQuarters());
    }

    /**
     * @test
     */
    public function testGetHeadQuartersFailure()
    {
        $this->setRequestTvNetworkEmpty();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEmpty($network->getHeadQuarters());
    }

    /**
     * @test
     */
    public function testGetHomepage()
    {
        $this->setRequestOk();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEquals('http://www.fujitv.co.jp', $network->getHomePage());
    }

    /**
     * @test
     */
    public function testGetHomepageFailure()
    {
        $this->setRequestTvNetworkEmpty();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEmpty($network->getHomePage());
    }

    /**
     * @test
     */
    public function testGetOriginCountry()
    {
        $this->setRequestOk();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEquals('JP', $network->getOriginCountry());
    }

    /**
     * @test
     */
    public function testGetOriginCountryFailure()
    {
        $this->setRequestTvNetworkEmpty();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEmpty($network->getHomePage());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEquals('/3/network/'.$this->network_id, parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals($this->network_id, $network->getId());
    }

    /**
     * @test
     */
    public function testGetIdFailure()
    {
        $this->setRequestTvNetworkEmpty();

        $network = new TVNetwork($this->tmdb, $this->network_id);

        $this->assertEquals(0, $network->getId());
    }

    /**
      * @test
      */
    public function testGetLogos()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVNetworkImagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $network = new TVNetwork($this->tmdb, $this->network_id);
        $logos = $network->getLogos();

        $this->assertInstanceOf(\Generator::class, $logos);
        foreach ($logos as $l) {
            $this->assertEquals('/3/network/'.$this->network_id.'/images', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Logo::class, $l);
        }
    }
}
