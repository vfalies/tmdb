<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Tmdb;
use VfacTmdb\Auth;
use VfacTmdb\Results;
use VfacTmdb\Account;
use VfacTmdb\Account\Favorite;
use VfacTmdb\Exceptions\ServerErrorException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class FavoriteTest extends TestCase
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

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountFavoriteMoviesOk.json')));
        $favorite = $account->getFavorite();
        $movies   = $favorite->getMovies();

        $this->assertEquals('/3/account/'.$account->getId().'/favorite/movies', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($movies as $movie) {
            $this->assertInstanceOf(Results\Movie::class, $movie);
        }

        $this->assertEquals(1, $favorite->getPage());
        $this->assertEquals(4, $favorite->getTotalPages());
        $this->assertEquals(77, $favorite->getTotalResults());
    }

    public function testGetTVShows()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountFavoriteTVShowsOk.json')));
        $tvs = $account->getFavorite()->getTVShows();

        $this->assertEquals('/3/account/'.$account->getId().'/favorite/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv) {
            $this->assertInstanceOf(Results\TVShow::class, $tv);
        }
    }

    /**
     * @expectedException \VfacTmdb\Exceptions\ServerErrorException
     */
    public function testMarkMovieAsFavoriteFailed()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->will($this->throwException(new ServerErrorException));
        $fav = $account->getFavorite()->markMovieAsFavorite(11);
    }

    public function testMarkMovieAsFavorite()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountMarkFavoriteOk.json')));
        $fav = $account->getFavorite()->markMovieAsFavorite(11);

        $this->assertEquals('/3/account/'.$account->getId().'/favorite', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(Favorite::class, $fav);
    }

    public function testUnMarkMovieAsFavorite()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountMarkFavoriteOk.json')));
        $fav = $account->getFavorite()->unmarkMovieAsFavorite(11);

        $this->assertEquals('/3/account/'.$account->getId().'/favorite', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(Favorite::class, $fav);
    }

    public function testMarkTVShowAsFavorite()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountMarkFavoriteOk.json')));
        $fav = $account->getFavorite()->markTVShowAsFavorite(11);

        $this->assertEquals('/3/account/'.$account->getId().'/favorite', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(Favorite::class, $fav);
    }

    public function testUnMarkTVShowAsFavorite()
    {
        $session_id = $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $session_id);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountMarkFavoriteOk.json')));
        $fav = $account->getFavorite()->unmarkTVShowAsFavorite(11);

        $this->assertEquals('/3/account/'.$account->getId().'/favorite', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertInstanceOf(Favorite::class, $fav);
    }
}
