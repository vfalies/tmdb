<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

/**
 * @cover Movie
 */
class MovieTest extends TestCase
{

    protected $tmdb   = null;
    protected $result = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['getRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function getRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchMovieOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $search       = new \vfalies\tmdb\Search($this->tmdb);
        $this->result = $search->movie('star wars', array('language' => 'fr-FR'))->current();
    }

    private function getRequestConfNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchMovieOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $search       = new \vfalies\tmdb\Search($this->tmdb);
        $this->result = $search->movie('star wars', array('language' => 'fr-FR'))->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertInternalType('int', $this->result->getId());
        $this->assertEquals(11, $this->result->getId());
    }

    /**
     * @test
     * @expectedException \vfalies\tmdb\Exceptions\NotFoundException
     */
    public function testContructFailed()
    {
        $result = new \stdClass();
        $result->not_property = 'test';

        new \vfalies\tmdb\Results\Movie($this->tmdb, $result);
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->getRequestOk();

        $this->assertInternalType('string', $this->result->getOverview());
        $this->assertStringStartsWith('Il y a bien longtemps, dans une galaxie très lointaine...', $this->result->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->getRequestOk();

        $this->assertInternalType('string', $this->result->getReleaseDate());
        $this->assertEquals('1977-05-25', $this->result->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->getRequestOk();

        $this->assertInternalType('string', $this->result->getOriginalTitle());
        $this->assertEquals('Star Wars', $this->result->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->getRequestOk();

        $this->assertInternalType('string', $this->result->getTitle());
        $this->assertEquals('La Guerre des étoiles', $this->result->getTitle());
    }
}
