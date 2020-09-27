<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class TVSeasonTest extends TestCase
{
    protected $tmdb   = null;
    protected $result = null;
    protected $tv_id  = 253;
    protected $season = null;

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

        $json_object = json_decode(file_get_contents('tests/json/TVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $TVShow       = new \VfacTmdb\Items\TVShow($this->tmdb, $this->tv_id);
        $this->season = $TVShow->getSeasons()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/tv/'.$this->tv_id, parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->season->getId());
        $this->assertEquals(816, $this->season->getId());
    }

    /**
     * @test
     */
    public function testGetAirDate()
    {
        $this->getRequestOk();

        $this->assertIsString($this->season->getAirDate());
        $this->assertEquals('1988-10-15', $this->season->getAirDate());
    }

    /**
     * @test
     */
    public function testGetEpisodeCount()
    {
        $this->getRequestOk();

        $this->assertEquals(5, $this->season->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->getRequestOk();

        $this->assertEquals(0, $this->season->getSeasonNumber());
    }
}
