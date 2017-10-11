<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Auth;
use vfalies\tmdb\Results;
use vfalies\tmdb\Account;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

class FavoriteTest extends TestCase
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
                ->setMethods(['sendRequest'])
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

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountFavoriteMoviesOk.json')));
        $movies = $account->getFavorite()->getMovies();

        $this->assertEquals('/3/account/'.$account->getId().'/favorite/movies', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($movies as $movie)
        {
            $this->assertInstanceOf(Results\Movie::class, $movie);
        }
    }

    public function testGetTVShows()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/configurationOk.json')));
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountFavoriteTVShowsOk.json')));
        $tvs = $account->getFavorite()->getTVShows();

        $this->assertEquals('/3/account/'.$account->getId().'/favorite/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($tvs as $tv)
        {
            $this->assertInstanceOf(Results\TVShow::class, $tv);
        }
    }

}
