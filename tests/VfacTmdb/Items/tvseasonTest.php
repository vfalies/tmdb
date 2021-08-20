<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class TVSeasonTest extends TestCase
{
    protected $tmdb          = null;
    protected $tvseason      = null;
    protected $tv_id         = 11;
    protected $season_number = 1;

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

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestTVSeasonCredit()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_tvseasonOk = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $json_creditOk = json_decode(file_get_contents('tests/json/creditOk.json'));

        $this->tmdb->method('sendRequest')->will($this->onConsecutiveCalls($json_tvseasonOk, $json_creditOk));
    }

    private function setRequestTVSeasonEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals('/3/tv/'.$this->tv_id.'/season/'.$this->season_number, parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals('Season 1', $TVSeason->getName());
    }

    /**
     * @test
     */
    public function testGetNameEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEmpty($TVSeason->getName());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertStringStartsWith('Trouble is brewing in the Seven Kingdoms of Westeros', $TVSeason->getOverview());
    }

    /**
     * @test
     */
    public function testGetOverviewEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEmpty($TVSeason->getOverview());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(3624, $TVSeason->getId());
    }

    /**
     * @test
     */
    public function testGetIdEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(0, $TVSeason->getId());
    }

    /**
     * @test
     */
    public function testGetAirDate()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals("2011-04-17", $TVSeason->getAirDate());
    }

    /**
     * @test
     */
    public function testGetAirDateEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals('', $TVSeason->getAirDate());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(1, $TVSeason->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetSeasonNumberEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(0, $TVSeason->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetEpisodesCount()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(10, $TVSeason->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetEpisodesCountEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(0, $TVSeason->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetEpisodes()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $seasons = $TVSeason->getEpisodes();
        $this->assertInstanceOf(\Generator::class, $seasons);

        foreach ($seasons as $season) {
            $this->assertInstanceOf(\VfacTmdb\Results\TVEpisode::class, $season);
        }
    }

    /**
     * test
     */
    public function testGetEpisodesEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);
        $seasons  = $TVSeason->getEpisodes();

        $this->assertInstanceOf(\Generator::class, $seasons);
        $this->assertNull($seasons->current());
    }

    public function testGetPosters()
    {
        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $posters = $TVSeason->getPosters();

        $this->assertInstanceOf(\Generator::class, $posters);

        foreach ($posters as $p) {
            $this->assertEquals('/3/tv/'.$this->tv_id.'/season/'.$this->season_number.'/images', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Image::class, $p);
        }
    }


    /**
     * @test
     */
    public function testGetCrew()
    {
        $this->setRequestTVSeasonCredit();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);
        $Crew      = $TVSeason->getCrew();

        $this->assertInstanceOf(\Generator::class, $Crew);
        foreach ($Crew as $c) {
            $this->assertInstanceOf(\VfacTmdb\Results\Crew::class, $c);
        }
    }

    /**
     * @test
     */
    public function testGetCast()
    {
        $this->setRequestTVSeasonCredit();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);
        $Cast      = $TVSeason->getCast();

        $this->assertInstanceOf(\Generator::class, $Cast);
        foreach ($Cast as $c) {
            $this->assertInstanceOf(\VfacTmdb\Results\Cast::class, $c);
        }
    }
}
