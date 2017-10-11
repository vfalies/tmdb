<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Auth;
use vfalies\tmdb\Results;
use vfalies\tmdb\Account;
use vfalies\tmdb\Account\WatchList;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

class WatchListTest extends TestCase
{
    /**
     * Tmdb
     * @var Tmdb
     */
    protected $tmdb          = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getStatusCode'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }


    public function createSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn($json_object);

        $this->auth = new Auth($this->tmdb);
        $this->auth->createSession();
    }

    public function testGetMovies()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountWatchListMoviesOk.json')));
        $movies = $account->getWatchList()->getMovies();

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist/movies', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($movies as $movie) {
            $this->assertInstanceOf(Results\Movie::class, $movie);
        }
    }

    public function testGetTVShows()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountWatchListTVShowsOk.json')));
        $tvs = $account->getWatchList()->getTVShows();

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVShow::class, $tv);
        }
    }

    public function testAddMovie()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountAddToWatchList.json')));
        $watchlist = $account->getWatchList()->addMovie(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testRemoveMovie()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountAddToWatchList.json')));
        $watchlist = $account->getWatchList()->removeMovie(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testAddTVShow()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountAddToWatchList.json')));
        $watchlist = $account->getWatchList()->addTVShow(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    public function testRemoveTVShow()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountAddToWatchList.json')));
        $watchlist = $account->getWatchList()->removeTVShow(11);

        $this->assertEquals('/3/account/'.$account->getId().'/watchlist', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(WatchList::class, $watchlist);
    }

    /**
     * @expectedException \vfalies\tmdb\Exceptions\ServerErrorException
     */
    public function testAddMovieFailed()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->will($this->throwException(new ServerErrorException));
        $fav = $account->getWatchList()->addMovie(11);
    }
}
