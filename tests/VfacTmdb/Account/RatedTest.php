<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Tmdb;
use VfacTmdb\Auth;
use VfacTmdb\Results;
use VfacTmdb\Account;
use VfacTmdb\Account\Rated;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class RatedTest extends TestCase
{
    /**
     * Tmdb
     * @var Tmdb
     */
    protected $tmdb          = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getStatusCode'])
                ->getMock();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->tmdb = null;
    }


    public function createSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn($json_object);

        $this->auth = new Auth($this->tmdb);
        return $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');
    }

    public function testGetMovies()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountRatedMoviesOk.json')));
        $movies = $account->getRated()->getMovies();

        $this->assertEquals('/3/account/'.$account->getId().'/rated/movies', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($movies as $movie) {
            $this->assertInstanceOf(Results\Movie::class, $movie);
        }
    }

    public function testGetTVShows()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountRatedTVShowsOk.json')));
        $tvs = $account->getRated()->getTVShows();

        $this->assertEquals('/3/account/'.$account->getId().'/rated/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVShow::class, $tv);
        }
    }

    public function testGetTVEpisodes()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountRatedTVEpisodesOk.json')));
        $tvs = $account->getRated()->getTVEpisodes();

        $this->assertEquals('/3/account/'.$account->getId().'/rated/tv/episodes', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVEpisode::class, $tv);
        }
    }

    public function testAddMovieRate()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/movieratingOk.json')));
        $res = $account->getRated()->addMovieRate(11, 8);

        $this->assertEquals('/3/movie/11/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testAddTVShowRate()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/movieratingOk.json')));
        $res = $account->getRated()->addTVShowRate(1399, 8);

        $this->assertEquals('/3/tv/1399/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testAddTVShowEpisodeRate()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/movieratingOk.json')));
        $res = $account->getRated()->addTVShowEpisodeRate(1399, 1, 3, 8);

        $this->assertEquals('/3/tv/1399/season/1/episode/3/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testRemoveMovieRate()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/movieratingOk.json')));
        $res = $account->getRated()->removeMovieRate(11);

        $this->assertEquals('/3/movie/11/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testRemoveTVShowRate()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/movieratingOk.json')));
        $res = $account->getRated()->removeTVShowRate(1399);

        $this->assertEquals('/3/tv/1399/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testRemoveTVShowEpisodeRate()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/movieratingOk.json')));
        $res = $account->getRated()->RemoveTVShowEpisodeRate(1399, 1, 3);

        $this->assertEquals('/3/tv/1399/season/1/episode/3/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    /**
     * @expectedException VfacTmdb\Exceptions\TmdbException
     */
    public function testAddMovieRateFailed()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->will($this->throwException(new TmdbException));
        $res = $account->getRated()->addMovieRate(11, 8);
    }

    /**
     * @expectedException VfacTmdb\Exceptions\TmdbException
     */
    public function testRemoveMovieRateFailed()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->will($this->throwException(new TmdbException));
        $res = $account->getRated()->removeMovieRate(11);
    }
}
