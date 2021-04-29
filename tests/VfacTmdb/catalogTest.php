<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class CatalogTest extends TestCase
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
    public function testGetMovieList()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $genres = new Catalog($this->tmdb);
        $list   = $genres->getMovieGenres(array('language' => 'fr-FR'));

        $genre = $list->current();

        $this->assertEquals('/3/genre/movie/list', parse_url($this->tmdb->url, PHP_URL_PATH));

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

        $genres = new Catalog($this->tmdb);
        $list   = $genres->getMovieGenres(array('language' => 'fr-FR'));

        $genre = $list->current();

        $this->assertNull($genre);
    }

    /**
     * @test
     */
    public function testGetMovieGenresNok()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new TmdbException()));

        $this->expectException(\Exception::class);
        $genres = new Catalog($this->tmdb);
        $genres->getMovieGenres(array('language' => 'fr-FR'));
    }

    /**
     * @test
     */
    public function testGetMovieListNok()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new TmdbException()));

        $this->expectException(\Exception::class);
        $genres = new Catalogs\Genres($this->tmdb);
        $genres->getMovieList(array('language' => 'fr-FR'));
    }

    /**
     * @test
     */
    public function testGetTVListNok()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new TmdbException()));

        $this->expectException(\Exception::class);
        $genres = new Catalog($this->tmdb);
        $genres->getTVShowGenres(array('language' => 'fr-FR'));
    }

    /**
     * @test
     */
    public function testGetTVList()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresTVOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $genres = new Catalog($this->tmdb);
        $list   = $genres->getTVShowGenres(array('language' => 'fr-FR'));

        $genre = $list->current();

        $this->assertEquals('/3/genre/tv/list', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertEquals(10759, $genre->id);
        $this->assertEquals('Action & Adventure', $genre->name);
    }

    /**
     * @test
     */
    public function tetsGetJobs()
    {
        $json_object = json_decode(file_get_contents('tests/json/jobsOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $jobs = new Catalog($this->tmdb);
        $list = $jobs->getJobsList(array('language' => 'fr-FR'));

        $this->assertEquals('/3/job/list', parse_url($this->tmdb->url, PHP_URL_PATH));

        foreach ($list as $job) {
            $this->assertEquals('Writing', $job->department);
        }
    }

    /**
     * @test
     */
    public function tetsGetJobsNok()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new TmdbException()));

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $jobs = new Catalog($this->tmdb);
        $list = $jobs->getJobsList(array('wrong option'));
    }
}
