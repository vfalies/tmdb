<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class PeopleMovieCastTest extends TestCase
{
    protected $tmdb          = null;
    protected $result        = null;
    protected $people_id         = 66633;
    protected $moviecast = null;

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

        $People      = new \VfacTmdb\Items\People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleMovieCreditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->moviecast = $People->getMoviesCast()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/person/'.$this->people_id.'/movie_credits', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->moviecast->getId());
        $this->assertEquals(239459, $this->moviecast->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->getRequestOk();

        $this->assertEquals('52fe4e93c3a36847f8299dff', $this->moviecast->getCreditId());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->getRequestOk();

        $this->assertEquals('No Half Measures: Creating the Final Season of Breaking Bad', $this->moviecast->getTitle());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->getRequestOk();

        $this->assertEquals('No Half Measures: Creating the Final Season of Breaking Bad', $this->moviecast->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetCharacter()
    {
        $this->getRequestOk();

        $this->assertEquals('Himself', $this->moviecast->getCharacter());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->getRequestOk();

        $this->assertEquals('2013-11-26', $this->moviecast->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetAdult()
    {
        $this->getRequestOk();

        $this->assertEquals(false, $this->moviecast->getAdult());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->getRequestOk();

        $this->assertEquals('/8OixSR45U5dbqv8F0tlspmTbXxN.jpg', $this->moviecast->getPosterPath());
    }
}
