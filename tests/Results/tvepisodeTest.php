<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

/**
 * @cover TVEpisode
 */
class TVEpisodeTest extends TestCase
{

    protected $tmdb          = null;
    protected $result        = null;
    protected $tv_id         = 253;
    protected $season_number = 1;
    protected $episode       = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
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
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->episode->getId());
        $this->assertEquals(63056, $this->episode->getId());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->sendRequestOk();

        $this->assertEquals(1, $this->episode->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetAirDate()
    {
        $this->sendRequestOk();

        $this->assertEquals('2011-04-17', $this->episode->getAirDate());
    }

    /**
     * @test
     */
    public function testGetEpisodeNumber()
    {
        $this->sendRequestOk();

        $this->assertEquals(1, $this->episode->getEpisodeNumber());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->sendRequestOk();

        $this->assertEquals('Winter Is Coming', $this->episode->getName());
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $this->sendRequestOk();

        $this->assertInternalType('double', $this->episode->getNote());
        $this->assertEquals('7.11904761904762', $this->episode->getNote());
    }

    /**
     * @test
     */
    public function testGetNoteCount()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->episode->getNoteCount());
        $this->assertEquals(21, $this->episode->getNoteCount());
    }

    /**
     * @test
     */
    public function testGetProductionCode()
    {
        $this->sendRequestOk();

        $this->assertInternalType('string', $this->episode->getProductionCode());
        $this->assertEquals('101', $this->episode->getProductionCode());
    }

    /**
     * @test
     */
    public function testGetStillPath()
    {
        $this->sendRequestOk();

        $this->assertInternalType('string', $this->episode->getStillPath());
        $this->assertEquals('/wrGWeW4WKxnaeA8sxJb2T9O6ryo.jpg', $this->episode->getStillPath());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->sendRequestOk();

        $this->assertStringStartsWith('Jon Arryn, the Hand of the King, is dead.', $this->episode->getOverview());
    }

    /**
     * @test
     */
    public function testGetCrew()
    {
        $this->sendRequestOk();

        $Crew = $this->episode->getCrew();
        $this->assertInstanceOf(\Generator::class, $Crew);

        foreach ($Crew as $c)
        {
            $this->assertInstanceOf(\vfalies\tmdb\Results\Crew::class, $c);
        }
    }

    /**
     * @test
     */
    public function testGetGuestStars()
    {
        $this->sendRequestOk();

        $stars = $this->episode->getGuestStars();

        $i = 0;
        foreach ($stars as $star)
        {
            if ($i == 0)
            {
                $this->assertEquals(117642, $star->getId());
            }
            $i++;
        }

    }

}
