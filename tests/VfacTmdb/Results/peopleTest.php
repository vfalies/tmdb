<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class PeopleTest extends TestCase
{
    protected $tmdb   = null;
    protected $result = null;

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

        $json_object = json_decode(file_get_contents('tests/json/searchPeopleOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \VfacTmdb\Search($this->tmdb);
        $this->result = $search->people('Bradley Cooper', array('language' => 'fr-FR'))->current();
    }

    private function getRequestConfNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchPeopleOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \VfacTmdb\Search($this->tmdb);
        $this->result = $search->people('Bradley Cooper', array('language' => 'fr-FR'))->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/search/person', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->result->getId());
        $this->assertEquals(51329, $this->result->getId());
    }

    /**
     * @test
     */
    public function testGetAdult()
    {
        $this->getRequestOk();

        $this->assertEquals(false, $this->result->getAdult());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals("Bradley Cooper", $this->result->getName());
    }

    /**
     * @test
     */
    public function testGetProfilePath()
    {
        $this->getRequestOk();

        $this->assertEquals("/2daC5DeXqwkFND0xxutbnSVKN6c.jpg", $this->result->getProfilePath());
    }

    /**
     * @test
     */
    public function testGetPopularity()
    {
        $this->getRequestOk();

        $this->assertEquals(6.431053, $this->result->getPopularity());
    }
}
