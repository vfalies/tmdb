<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover PeopleTVShowCrew
 */
class PeopleTVShowCrewTest extends TestCase
{

    protected $tmdb      = null;
    protected $result    = null;
    protected $people_id = 66633;
    protected $moviecrew = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function sendRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $People = new \vfalies\tmdb\Items\People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleTVShowCreditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->moviecrew = $People->getTVShowCrew()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->moviecrew->getId());
        $this->assertEquals(1396, $this->moviecrew->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->sendRequestOk();

        $this->assertEquals('52542287760ee31328001af1', $this->moviecrew->getCreditId());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->sendRequestOk();

        $this->assertEquals('Breaking Bad', $this->moviecrew->getName());
    }

    /**
     * @test
     */
    public function testGetOriginalName()
    {
        $this->sendRequestOk();

        $this->assertEquals('Breaking Bad', $this->moviecrew->getOriginalName());
    }

    /**
     * @test
     */
    public function testGetDepartment()
    {
        $this->sendRequestOk();

        $this->assertEquals('Production', $this->moviecrew->getDepartment());
    }

    /**
     * @test
     */
    public function testGetFirstAirDate()
    {
        $this->sendRequestOk();

        $this->assertEquals('2008-01-19', $this->moviecrew->getFirstAirDate());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->sendRequestOk();

        $this->assertEquals('/1yeVJox3rjo2jBKrrihIMj7uoS9.jpg', $this->moviecrew->getPosterPath());
    }

    /**
     * @test
     */
    public function testGetEpisodeCount()
    {
        $this->sendRequestOk();

        $this->assertEquals(68, $this->moviecrew->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetJob()
    {
        $this->sendRequestOk();

        $this->assertEquals('Executive Producer', $this->moviecrew->getJob());
    }

}
