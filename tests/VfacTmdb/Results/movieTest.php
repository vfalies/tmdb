<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class MovieTest extends TestCase
{
    protected $tmdb   = null;
    protected $result = null;

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

    private function getRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \VfacTmdb\Search($this->tmdb);
        $this->result = $search->movie('star wars', array('language' => 'fr-FR'))->current();
    }

    private function getRequestConfNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \VfacTmdb\Search($this->tmdb);
        $this->result = $search->movie('star wars', array('language' => 'fr-FR'))->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/search/movie', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->result->getId());
        $this->assertEquals(11, $this->result->getId());
    }

    /**
     * @test
     */
    public function testContructFailed()
    {
        $result = new \stdClass();
        $result->not_property = 'test';

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        new \VfacTmdb\Results\Movie($this->tmdb, $result);
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->getRequestOk();

        $this->assertIsString($this->result->getOverview());
        $this->assertStringStartsWith('Il y a bien longtemps, dans une galaxie très lointaine...', $this->result->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->getRequestOk();

        $this->assertIsString($this->result->getReleaseDate());
        $this->assertEquals('1977-05-25', $this->result->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->getRequestOk();

        $this->assertIsString($this->result->getOriginalTitle());
        $this->assertEquals('Star Wars', $this->result->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->getRequestOk();

        $this->assertIsString($this->result->getTitle());
        $this->assertEquals('La Guerre des étoiles', $this->result->getTitle());
    }
}
