<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class FindTest extends TestCase
{
    protected $tmdb = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
                ->getMock();
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testFindMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/findIMDBMoviesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find    = new Find($this->tmdb);
        $responses = $find->imdb('tt0076759', array('language' => 'fr-FR'));

        $this->assertInstanceOf(Results\Find::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->getMovies()->current());

        return $find;
    }

    /**
     * @test
     */
    public function testFindMovieEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/findIMDBPeoplesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find    = new Find($this->tmdb);
        $responses = $find->imdb('tt0076759', array('language' => 'fr-FR'));

        $this->assertInstanceOf(Results\Find::class, $responses);
        $this->assertNull($responses->getMovies()->current());
    }

    /**
     * @test
     */
    public function testFindFailure()
    {
        $json_object = json_decode('');
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);

        $find    = new Find($this->tmdb);
        $responses = $find->imdb('tt0076759', array('language' => 'fr-FR'));
    }

    /**
     * @test
     */
    public function testFindFacebookMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/findFacebookMoviesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find    = new Find($this->tmdb);
        $responses = $find->facebook('harrypottermovie', array('language' => 'fr-FR'));

        $this->assertInstanceOf(Results\Find::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->getMovies()->current());

        return $find;
    }

    /**
     * @test
     */
    public function testFindTwitterMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/findTwitterMoviesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find    = new Find($this->tmdb);
        $responses = $find->twitter('HarryPotterFilm', array('language' => 'fr-FR'));

        $this->assertInstanceOf(Results\Find::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->getMovies()->current());

        return $find;
    }

    /**
     * @test
     */
    public function testFindInstagramMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/findInstagramMoviesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find    = new Find($this->tmdb);
        $responses = $find->instagram('harrypotterfilm', array('language' => 'fr-FR'));

        $this->assertInstanceOf(Results\Find::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->getMovies()->current());

        return $find;
    }

    /**
     * @test
     */
    public function testFindTVRagePeopleValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/findTVRagePeoplesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $find    = new Find($this->tmdb);
        $responses = $find->tvrage('36633', array('language' => 'fr-FR'));

        $this->assertInstanceOf(Results\Find::class, $responses);
        $this->assertInstanceOf(Results\People::class, $responses->getPeoples()->current());

        return $find;
    }
}
