<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class AlternativeNameTest extends TestCase
{
    protected $tmdb              = null;
    protected $result            = null;
    protected $network_id        = 13;
    protected $alternative_name = null;

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

    private function getRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/alternativeNamesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $TVNetwork              = new \VfacTmdb\Items\TVNetwork($this->tmdb, $this->network_id);
        $this->alternative_name = $TVNetwork->getAlternativeNames()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/network/'.$this->network_id.'/alternative_names', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->alternative_name->getId());
        $this->assertEquals(13, $this->alternative_name->getId());
    }

    /**
     * @test
     */
    public function testContructFailed()
    {
        $result               = new \stdClass();
        $result->not_property = 'test';

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        new \VfacTmdb\Results\AlternativeName($this->tmdb, 13, $result);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Nick Jr.', $this->alternative_name->getName());
    }

    /**
     * @test
     */
    public function testGetType()
    {
        $this->getRequestOk();

        $this->assertEquals('programming block', $this->alternative_name->getType());
    }
}
