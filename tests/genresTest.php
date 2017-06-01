<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Genres
 */
class GenresTest extends TestCase
{

    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testGetMovieList()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $genres = new Genres($this->tmdb);
        $list = $genres->getMovieList(array('language' => 'fr-FR'));

        $genre = $list->current();

        $this->assertEquals(28, $genre->id);
        $this->assertEquals('Action', $genre->name);
    }

    /**
     * @test
     */
    public function testGetMovieListNoResult()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $genres = new Genres($this->tmdb);
        $list = $genres->getMovieList(array('language' => 'fr-FR'));

        $genre = $list->current();

        $this->assertNull($genre);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetMovieListNok()
    {        
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        $genres = new Genres($this->tmdb);
        $genres->getMovieList(array('language' => 'fr-FR'));
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetTVListNok()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        $genres = new Genres($this->tmdb);
        $genres->getTVList(array('language' => 'fr-FR'));
    }

    /**
     * @test
     */
    public function testGetTVList()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresTVOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $genres = new Genres($this->tmdb);
        $list = $genres->getTVList(array('language' => 'fr-FR'));

        $genre = $list->current();

        $this->assertEquals(10759, $genre->id);
        $this->assertEquals('Action & Adventure', $genre->name);
    }
}
