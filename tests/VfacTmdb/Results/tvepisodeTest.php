<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class TVEpisodeTest extends TestCase
{
    protected $tmdb          = null;
    protected $result        = null;
    protected $tv_id         = 253;
    protected $season_number = 1;
    protected $episode       = null;

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

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $TVSeason      = new \VfacTmdb\Items\TVSeason($this->tmdb, $this->tv_id, $this->season_number);
        $this->episode = $TVSeason->getEpisodes()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/tv/'.$this->tv_id.'/season/'.$this->season_number, parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->episode->getId());
        $this->assertEquals(63056, $this->episode->getId());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->getRequestOk();

        $this->assertEquals(1, $this->episode->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetAirDate()
    {
        $this->getRequestOk();

        $this->assertEquals('2011-04-17', $this->episode->getAirDate());
    }

    /**
     * @test
     */
    public function testGetEpisodeNumber()
    {
        $this->getRequestOk();

        $this->assertEquals(1, $this->episode->getEpisodeNumber());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Winter Is Coming', $this->episode->getName());
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $this->getRequestOk();

        $this->assertIsFloat($this->episode->getNote());
        $this->assertEquals('7.11904761904762', $this->episode->getNote());
    }

    /**
     * @test
     */
    public function testGetNoteCount()
    {
        $this->getRequestOk();

        $this->assertIsInt($this->episode->getNoteCount());
        $this->assertEquals(21, $this->episode->getNoteCount());
    }

    /**
     * @test
     */
    public function testGetProductionCode()
    {
        $this->getRequestOk();

        $this->assertIsString($this->episode->getProductionCode());
        $this->assertEquals('101', $this->episode->getProductionCode());
    }

    /**
     * @test
     */
    public function testGetStillPath()
    {
        $this->getRequestOk();

        $this->assertIsString($this->episode->getStillPath());
        $this->assertEquals('/wrGWeW4WKxnaeA8sxJb2T9O6ryo.jpg', $this->episode->getStillPath());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->getRequestOk();

        $this->assertStringStartsWith('Jon Arryn, the Hand of the King, is dead.', $this->episode->getOverview());
    }

    /**
     * @test
     */
    public function testGetCrew()
    {
        $this->getRequestOk();

        $Crew = $this->episode->getCrew();
        $this->assertInstanceOf(\Generator::class, $Crew);

        foreach ($Crew as $c) {
            $this->assertInstanceOf(\VfacTmdb\Results\Crew::class, $c);
        }
    }

    /**
     * @test
     */
    public function testGetGuestStars()
    {
        $this->getRequestOk();

        $stars = $this->episode->getGuestStars();

        $i = 0;
        foreach ($stars as $star) {
            if ($i == 0) {
                $this->assertEquals(117642, $star->getId());
            }
            $i++;
        }
    }
}
