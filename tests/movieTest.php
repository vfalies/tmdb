<?php

namespace Vfac\Tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Movie
 */
class MovieTest extends TestCase
{

    protected $tmdb     = null;
    protected $movie    = null;
    protected $movie_id = 11;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testGetAllGenres()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie  = new Movie($this->tmdb, $this->movie_id);
        $genres = $movie->getAllGenres();

        $this->assertArrayHasKey(12, $genres); // 12 : Aventure
        $this->assertEquals('Aventure', $genres[12]);
        $this->assertArrayHasKey(10770, $genres); // 10770 : Téléfilm
        $this->assertEquals('Téléfilm', $genres[10770]);
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('La Guerre des étoiles', $movie->getTitle());
    }

    /**
     * @test
     */
    public function testGetGenres()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertCount(3, $movie->getGenres());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('string', $movie->getOverview());
        $this->assertStringStartsWith('Il y a bien longtemps, dans une galaxie très lointaine...', $movie->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('1977-05-25', $movie->getReleaseDate());
    }

    /**
     * @test
     */
    public function testOriginalTitle()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('Star Wars', $movie->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('double', $movie->getNote());
        $this->assertEquals('8', $movie->getNote());
    }

    /**
     * @test
     */
    public function testGetIMDBId()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('string', $movie->getIMDBId());
        $this->assertEquals('tt0076759', $movie->getIMDBId());
    }

    /**
     * @test
     */
    public function testGetTagline()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('string', $movie->getTagLine());
        $this->assertEquals('Il y a bien longtemps dans une galaxie très lointaine...', $movie->getTagLine());
    }

    /**
     * @test
     */
    public function testCollectionId()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('int', $movie->getCollectionId());
        $this->assertEquals('10', $movie->getCollectionId());
    }

    /**
     * @test
     */
    public function testGetPoster()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertNotFalse(filter_var($movie->getPoster(), FILTER_VALIDATE_URL));
    }

    /**
     * @test
     */
    public function testGetBackdrop()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertNotFalse(filter_var($movie->getBackdrop(), FILTER_VALIDATE_URL));
    }
}
