<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class PeopleTVShowCrewTest extends TestCase
{
    protected $tmdb      = null;
    protected $result    = null;
    protected $people_id = 66633;
    protected $moviecrew = null;

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

        $People = new \VfacTmdb\Items\People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleTVShowCreditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->moviecrew = $People->getTVShowCrew()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/person/'.$this->people_id.'/tv_credits', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->moviecrew->getId());
        $this->assertEquals(1396, $this->moviecrew->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->getRequestOk();

        $this->assertEquals('52542287760ee31328001af1', $this->moviecrew->getCreditId());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Breaking Bad', $this->moviecrew->getName());
    }

    /**
     * @test
     */
    public function testGetOriginalName()
    {
        $this->getRequestOk();

        $this->assertEquals('Breaking Bad', $this->moviecrew->getOriginalName());
    }

    /**
     * @test
     */
    public function testGetDepartment()
    {
        $this->getRequestOk();

        $this->assertEquals('Production', $this->moviecrew->getDepartment());
    }

    /**
     * @test
     */
    public function testGetFirstAirDate()
    {
        $this->getRequestOk();

        $this->assertEquals('2008-01-19', $this->moviecrew->getFirstAirDate());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->getRequestOk();

        $this->assertEquals('/1yeVJox3rjo2jBKrrihIMj7uoS9.jpg', $this->moviecrew->getPosterPath());
    }

    /**
     * @test
     */
    public function testGetEpisodeCount()
    {
        $this->getRequestOk();

        $this->assertEquals(68, $this->moviecrew->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetJob()
    {
        $this->getRequestOk();

        $this->assertEquals('Executive Producer', $this->moviecrew->getJob());
    }
}
