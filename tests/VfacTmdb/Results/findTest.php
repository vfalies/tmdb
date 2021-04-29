<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class FindTest extends TestCase
{
    protected $tmdb              = null;
    protected $result_movies     = null;
    protected $result_peoples    = null;
    protected $result_tvshows    = null;
    protected $result_tvepisodes = null;
    protected $result_tvseasons = null;
    protected $network_id        = 13;
    protected $alternative_name  = null;

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

    private function getRequestMoviesOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/findIMDBMoviesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find       = new \VfacTmdb\Find($this->tmdb);
        $this->result_movies = $find->imdb('tt0076759');
    }

    private function getRequestPeoplesOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/findIMDBPeoplesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find       = new \VfacTmdb\Find($this->tmdb);
        $this->result_peoples = $find->imdb('nm0000148');
    }

    private function getRequestTVShowsOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/findIMDBTVShowsOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find       = new \VfacTmdb\Find($this->tmdb);
        $this->result_tvshows = $find->imdb('tt0944947');
    }

    private function getRequestTVEpisodesOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/findIMDBTVEpisodesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find       = new \VfacTmdb\Find($this->tmdb);
        $this->result_tvepisodes = $find->imdb('tt5924366');
    }

    private function getRequestTVSeasonsOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/findTVDBTVSeasonsOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find       = new \VfacTmdb\Find($this->tmdb);
        $this->result_tvseasons = $find->tvdb('488434');
    }

    /**
     * @test
     */
    public function testContructFailed()
    {
        $result               = new \stdClass();
        $result->not_property = 'test';

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        new \VfacTmdb\Results\Find($this->tmdb, $result);
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestMoviesOk();
        $this->assertEquals(0, $this->result_movies->getId());
    }

    /**
     * @test
     */
    public function testGetMovies()
    {
        $this->getRequestMoviesOk();

        $this->assertEquals('Star Wars', $this->result_movies->getMovies()->current()->getTitle());
    }

    /**
     * @test
     */
    public function testGetMoviesEmpty()
    {
        $this->getRequestPeoplesOk();
        $this->assertEmpty($this->result_peoples->getMovies()->current());
    }

    /**
     * @test
     */
    public function testGetPeoplesEmpty()
    {
        $this->getRequestMoviesOk();
        $this->assertEmpty($this->result_movies->getPeoples()->current());
    }

    /**
     * @test
     */
    public function testGetTVShowsEmpty()
    {
        $this->getRequestPeoplesOk();
        $this->assertEmpty($this->result_peoples->getTVShows()->current());
    }

    /**
     * @test
     */
    public function testGetTVEpisodesEmpty()
    {
        $this->getRequestPeoplesOk();
        $this->assertEmpty($this->result_peoples->getTVEpisodes()->current());
    }

    /**
     * @test
     */
    public function testGetTVSeasonsEmpty()
    {
        $this->getRequestPeoplesOk();
        $this->assertEmpty($this->result_peoples->getTVSeasons()->current());
    }

    /**
     * @test
     */
    public function testGetPeoples()
    {
        $this->getRequestPeoplesOk();
        $this->assertEquals('Harrison Ford', $this->result_peoples->getPeoples()->current()->getName());
    }

    /**
     * @test
     */
    public function testGetTVShows()
    {
        $this->getRequestTVShowsOk();

        $this->assertEquals('Game of Thrones', $this->result_tvshows->getTVShows()->current()->getTitle());
    }

    /**
     * @test
     */
    public function testGetTVEpisodes()
    {
        $this->getRequestTVEpisodesOk();

        $this->assertEquals('Winterfell', $this->result_tvepisodes->getTVEpisodes()->current()->getName());
    }

    /**
     * @test
     */
    public function testGetTVSeasons()
    {
        $this->getRequestTVSeasonsOk();
        $this->assertEquals(3, $this->result_tvseasons->getTVSeasons()->current()->getSeasonNumber());
    }
}
