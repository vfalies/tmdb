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
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->auth = new Auth($this->tmdb);
        return $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');
    }

    public function testGetMovies()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/accountRatedMoviesOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $movies = $account->getRated()->getMovies();

        $this->assertEquals('/3/account/'.$account->getId().'/rated/movies', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($movies as $movie) {
            $this->assertInstanceOf(Results\Movie::class, $movie);
        }
    }

    public function testGetTVShows()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/accountRatedTVShowsOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $tvs = $account->getRated()->getTVShows();

        $this->assertEquals('/3/account/'.$account->getId().'/rated/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVShow::class, $tv);
        }
    }

    public function testGetTVEpisodes()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/accountRatedTVEpisodesOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $tvs = $account->getRated()->getTVEpisodes();

        $this->assertEquals('/3/account/'.$account->getId().'/rated/tv/episodes', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVEpisode::class, $tv);
        }
    }

    public function testAddMovieRate()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/movieratingOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $res = $account->getRated()->addMovieRate(11, 8);

        $this->assertEquals('/3/movie/11/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testAddTVShowRate()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/movieratingOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $res = $account->getRated()->addTVShowRate(1399, 8);

        $this->assertEquals('/3/tv/1399/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testAddTVShowEpisodeRate()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/movieratingOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $res = $account->getRated()->addTVShowEpisodeRate(1399, 1, 3, 8);

        $this->assertEquals('/3/tv/1399/season/1/episode/3/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testRemoveMovieRate()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/movieratingOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $res = $account->getRated()->removeMovieRate(11);

        $this->assertEquals('/3/movie/11/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testRemoveTVShowRate()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/movieratingOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $res = $account->getRated()->removeTVShowRate(1399);

        $this->assertEquals('/3/tv/1399/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testRemoveTVShowEpisodeRate()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $rated           = json_decode(file_get_contents('tests/json/movieratingOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $rated
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $res = $account->getRated()->RemoveTVShowEpisodeRate(1399, 1, 3);

        $this->assertEquals('/3/tv/1399/season/1/episode/3/rating', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Rated::class, $res);
    }

    public function testAddMovieRateFailed()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $this->throwException(new TmdbException)
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->expectException(TmdbException::class);
        $res = $account->getRated()->addMovieRate(11, 8);
    }

    public function testRemoveMovieRateFailed()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $this->throwException(new TmdbException)
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->expectException(TmdbException::class);
        $res = $account->getRated()->removeMovieRate(11);
    }
}
