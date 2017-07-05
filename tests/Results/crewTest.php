<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Crew
 */
class CrewTest extends TestCase
{

    protected $tmdb          = null;
    protected $result        = null;
    protected $tv_id         = 253;
    protected $season_number = 1;
    protected $episode       = null;
    protected $crew          = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
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

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $TVSeason      = new \vfalies\tmdb\Items\TVSeason($this->tmdb, $this->tv_id, $this->season_number);
        $this->episode = $TVSeason->getEpisodes()->current();

        $this->crew = $this->episode->getCrew()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->crew->getId());
        $this->assertEquals(44797, $this->crew->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->sendRequestOk();

        $this->assertEquals('5256c8a219c2956ff6046e77', $this->crew->getCreditId());
    }

    /**
     * @test
     */
    public function testGetDepartment()
    {
        $this->sendRequestOk();

        $this->assertEquals('Directing', $this->crew->getDepartment());
    }

    /**
     * @test
     */
    public function testGetGender()
    {
        $this->sendRequestOk();

        $this->assertEquals(null, $this->crew->getGender());
    }

    /**
     * @test
     */
    public function testGetJob()
    {
        $this->sendRequestOk();

        $this->assertEquals('Director', $this->crew->getJob());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->sendRequestOk();

        $this->assertEquals('Tim Van Patten', $this->crew->getName());
    }

    /**
     * @test
     */
    public function testGetProfilePath()
    {
        $this->sendRequestOk();

        $this->assertEquals('/6b7l9YbkDHDOzOKUFNqBVaPjcgm.jpg', $this->crew->getProfilePath());
    }

}
