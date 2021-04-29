<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Tmdb;
use VfacTmdb\Auth;
use VfacTmdb\Results;
use VfacTmdb\Account;
use VfacTmdb\Account\WatchList;
use VfacTmdb\Exceptions\ServerErrorException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class WatchListTest extends TestCase
{
    /**
     * Tmdb
     * @var Tmdb
     */
    protected $tmdb          = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getStatusCode'])
                ->getMock();
    }

    public function tearDown() : void
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
        $watchlist       = json_decode(file_get_contents('tests/json/accountWatchListMoviesOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $watchlist
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');
        $account = new Account($this->tmdb, $session_id);

        $movies = $account->getWatchList()->getMovies();

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist/movies', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($movies as $movie) {
            $this->assertInstanceOf(Results\Movie::class, $movie);
        }
    }

    public function testGetTVShows()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $watchlist       = json_decode(file_get_contents('tests/json/accountWatchListTVShowsOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $watchlist
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $tvs = $account->getWatchList()->getTVShows();

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVShow::class, $tv);
        }
    }

    public function testAddMovie()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $watchlist       = json_decode(file_get_contents('tests/json/accountAddToWatchList.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $watchlist
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $watchlist = $account->getWatchList()->addMovie(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testRemoveMovie()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $watchlist       = json_decode(file_get_contents('tests/json/accountAddToWatchList.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $watchlist
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $watchlist = $account->getWatchList()->removeMovie(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testAddTVShow()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $watchlist       = json_decode(file_get_contents('tests/json/accountAddToWatchList.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $watchlist
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $watchlist = $account->getWatchList()->addTVShow(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testRemoveTVShow()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));
        $watchlist       = json_decode(file_get_contents('tests/json/accountAddToWatchList.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $watchlist
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $watchlist = $account->getWatchList()->removeTVShow(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testAddMovieFailed()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk,
                       $this->throwException(new ServerErrorException)
                   ));
        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->expectException(ServerErrorException::class);
        $fav = $account->getWatchList()->addMovie(11);
    }
}
