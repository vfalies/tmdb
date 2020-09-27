<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class PeopleMovieCrewTest extends TestCase
{
    protected $tmdb      = null;
    protected $result    = null;
    protected $people_id = 66633;
    protected $moviecrew = null;

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

        $People = new \VfacTmdb\Items\People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleMovieCreditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->moviecrew = $People->getMoviesCrew()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/person/'.$this->people_id.'/movie_credits', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->moviecrew->getId());
        $this->assertEquals(8960, $this->moviecrew->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->getRequestOk();

        $this->assertEquals('52fe44cbc3a36847f80aa581', $this->moviecrew->getCreditId());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->getRequestOk();

        $this->assertEquals('Hancock', $this->moviecrew->getTitle());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->getRequestOk();

        $this->assertEquals('Hancock', $this->moviecrew->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetDepartment()
    {
        $this->getRequestOk();

        $this->assertEquals('Writing', $this->moviecrew->getDepartment());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->getRequestOk();

        $this->assertEquals('2008-07-01', $this->moviecrew->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetAdult()
    {
        $this->getRequestOk();

        $this->assertEquals(false, $this->moviecrew->getAdult());
    }

    /**
     * @test
     */
    public function testGetJob()
    {
        $this->getRequestOk();

        $this->assertEquals('Screenplay', $this->moviecrew->getJob());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->getRequestOk();

        $this->assertEquals('/dsCxSr4w3g2ylhlZg3v5CB5Pid7.jpg', $this->moviecrew->getPosterPath());
    }
}
