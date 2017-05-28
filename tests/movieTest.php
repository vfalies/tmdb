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
                ->setMethods(['sendRequest','getConfiguration'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/genresOk.json'));
        $this->tmdb->expects($this->once())->method('sendRequest')->with('genre/movie/list')->willReturn($json_object);
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->expects($this->once())->method('sendRequest')->with('movie/'.$this->movie_id)->willReturn($json_object);
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $this->movie = new Movie($this->tmdb, $this->movie_id);
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
        $genres = $this->movie->getAllGenres();

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
        var_dump($this->movie);
        $this->assertEquals('La Guerre des étoiles', $this->movie->getTitle());
    }

}
