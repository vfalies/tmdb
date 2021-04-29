<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Results;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class MovieTest extends TestCase
{
    protected $tmdb     = null;
    protected $movie    = null;
    protected $movie_id = 11;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestMovieEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/movieEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testContructFailure()
    {
        $this->expectException(\Exception::class);
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new Movie($this->tmdb, $this->movie_id);
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('/3/movie/'.$this->movie_id, parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals('La Guerre des étoiles', $movie->getTitle());
    }

    /**
     * @test
     */
    public function testGetTitleFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getTitle());
    }

    /**
     * @test
     */
    public function testGetGenres()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertCount(3, $movie->getGenres());
    }

    /**
     * @test
     */
    public function testGetGenresFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getGenres());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertIsString($movie->getOverview());
        $this->assertStringStartsWith('Il y a bien longtemps, dans une galaxie très lointaine...', $movie->getOverview());
    }

    /**
     * @test
     */
    public function testGetOverviewFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('1977-05-25', $movie->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetReleaseDateFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getReleaseDate());
    }

    /**
     * @test
     */
    public function testOriginalTitle()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('Star Wars', $movie->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testOriginalTitleFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('8', $movie->getNote());
    }

    /**
     * @test
     */
    public function testGetNoteFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getNote());
    }

    /**
     * @test
     */
    public function testGetIMDBId()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertIsString($movie->getIMDBId());
        $this->assertEquals('tt0076759', $movie->getIMDBId());
    }

    /**
     * @test
     */
    public function testGetIMDBIdFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getIMDBId());
    }

    /**
     * @test
     */
    public function testGetTagline()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertIsString($movie->getTagLine());
        $this->assertEquals('Il y a bien longtemps dans une galaxie très lointaine...', $movie->getTagLine());
    }

    /**
     * @test
     */
    public function testGetTaglineFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getTagLine());
    }

    /**
     * @test
     */
    public function testCollectionId()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertIsInt($movie->getCollectionId());
        $this->assertEquals('10', $movie->getCollectionId());
    }

    /**
     * @test
     */
    public function testCollectionIdFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getCollectionId());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertIsString($movie->getPosterPath());
        $this->assertNotEmpty($movie->getPosterPath());
    }

    /**
     * @test
     */
    public function testGetPosterPathFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertIsString($movie->getPosterPath());
        $this->assertEmpty($movie->getPosterPath());
    }

    /**
      * @test
      */
    public function testGetBackdropPath()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);
        $this->assertIsString($movie->getBackdropPath());
        $this->assertNotEmpty($movie->getBackdropPath());
    }

    /**
     * @test
     */
    public function testGetBackdropPathFailure()
    {
        $this->setRequestMovieEmpty();
        $movie = new Movie($this->tmdb, $this->movie_id);
        $this->assertIsString($movie->getBackdropPath());
        $this->assertEmpty($movie->getBackdropPath());
    }

    /**
     * @test
     */
    public function testGetCrewOk()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/creditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $crew = $movie->getCrew();

        foreach ($crew as $c) {
            $this->assertInstanceOf(\VfacTmdb\Results\Crew::class, $c);
        }
    }

    /**
     * @test
     */
    public function testGetVideosOk()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/videosOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $videos = $movie->getVideos();

        foreach ($videos as $v) {
            $this->assertInstanceOf(\VfacTmdb\Results\Videos::class, $v);
        }
    }

    /**
     * @test
     */
    public function testGetCastOk()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/creditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $cast = $movie->getCast();

        foreach ($cast as $c) {
            $this->assertInstanceOf(\VfacTmdb\Results\Cast::class, $c);
        }
    }
    public function testGetProductionCompanies()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $companies = $movie->getProductionCompanies();
        $this->assertInstanceOf(\Generator::class, $companies);

        foreach ($companies as $c) {
            $this->assertInstanceOf(Results\Company::class, $c);
            $this->assertNotEmpty($c->getName());
        }
    }

    /**
     * @test
     */
    public function testGetProductionCountries()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $countries = $movie->getProductionCountries();
        $this->assertInstanceOf(\Generator::class, $countries);

        foreach ($countries as $c) {
            $this->assertInstanceOf(\stdClass::class, $c);
            $this->assertNotEmpty($c->name);
        }
    }


    public function testGetBackdrops()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $backdrops = $movie->getBackdrops();

        $this->assertInstanceOf(\Generator::class, $backdrops);

        foreach ($backdrops as $b) {
            $this->assertEquals('/3/movie/'.$this->movie_id.'/images', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Image::class, $b);
        }
    }

    public function testGetPosters()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $posters = $movie->getPosters();


        $this->assertInstanceOf(\Generator::class, $posters);
        foreach ($posters as $p) {
            $this->assertEquals('/3/movie/'.$this->movie_id.'/images', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Image::class, $p);
        }
    }

    public function testGetSimilar()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/movieSimilarOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $similar = $movie->getSimilar();

        $this->assertInstanceOf(\Generator::class, $similar);

        foreach ($similar as $s) {
            $this->assertEquals('/3/movie/'.$this->movie_id.'/similar', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Movie::class, $s);
            $this->assertEquals(106912, $s->getId());
            $this->assertEquals("Darna: The Return", $s->getTitle());
        }
    }
}
