<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class ChangeTest extends TestCase
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
    public function testChangesMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change    = new Change($this->tmdb);
        $responses = $change->movie();

        $this->assertEquals('/3/movie/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Change::class, $responses->current());

        return $change;
    }

    /**
     * @test
     */
    public function testChangesMovieEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesMovieEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change    = new Change($this->tmdb);
        $responses = $change->movie(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertNull($responses->current());
    }

    /**
     * @test
     */
    public function testChangesTVShowValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesTVOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change    = new Change($this->tmdb);
        $responses = $change->tvshow();

        $this->assertEquals('/3/tv/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Change::class, $responses->current());

        return $change;
    }

    /**
     * @test
     */
    public function testChangesTVShowEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesTVEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change    = new Change($this->tmdb);
        $responses = $change->tvshow(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertNull($responses->current());
    }

    /**
     * @test
     */
    public function testChangesPersonValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesPersonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change    = new Change($this->tmdb);
        $responses = $change->person();

        $this->assertEquals('/3/person/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Change::class, $responses->current());

        return $change;
    }

    /**
     * @test
     */
    public function testChangesPersonEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesPersonEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change    = new Change($this->tmdb);
        $responses = $change->person(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertNull($responses->current());
    }

    /**
     * @test
     */
    public function testChangesMovieInvalidDate()
    {
        $change = new Change($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $change->movie(array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     */
    public function testChangesTVShowInvalidDate()
    {
        $change = new Change($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $change->tvshow(array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     */
    public function testChangesPersonInvalidDate()
    {
        $change = new Change($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $change->person(array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     * @depends testChangesMovieValid
     */
    public function testGetPage($change)
    {
        $this->assertEquals(1, $change->getPage());
    }

    /**
     * @test
     * @depends testChangesMovieValid
     */
    public function testTotalPages($change)
    {
        $this->assertEquals(1, $change->getTotalPages());
    }

    /**
     * @test
     * @depends testChangesMovieValid
     */
    public function testTotalResults($change)
    {
        $this->assertEquals(1, $change->getTotalResults());
    }
}
