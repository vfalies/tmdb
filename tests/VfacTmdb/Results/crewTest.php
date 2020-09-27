<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class CrewTest extends TestCase
{
    protected $tmdb          = null;
    protected $result        = null;
    protected $tv_id         = 253;
    protected $season_number = 1;
    protected $episode       = null;
    protected $crew          = null;

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

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $TVSeason      = new \VfacTmdb\Items\TVSeason($this->tmdb, $this->tv_id, $this->season_number);
        $this->episode = $TVSeason->getEpisodes()->current();

        $this->crew = $this->episode->getCrew()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/tv/'.$this->tv_id.'/season/'.$this->season_number, parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->crew->getId());
        $this->assertEquals(44797, $this->crew->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->getRequestOk();

        $this->assertEquals('5256c8a219c2956ff6046e77', $this->crew->getCreditId());
    }

    /**
     * @test
     */
    public function testGetDepartment()
    {
        $this->getRequestOk();

        $this->assertEquals('Directing', $this->crew->getDepartment());
    }

    /**
     * @test
     */
    public function testGetGender()
    {
        $this->getRequestOk();

        $this->assertEquals(null, $this->crew->getGender());
    }

    /**
     * @test
     */
    public function testGetJob()
    {
        $this->getRequestOk();

        $this->assertEquals('Director', $this->crew->getJob());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Tim Van Patten', $this->crew->getName());
    }

    /**
     * @test
     */
    public function testGetProfilePath()
    {
        $this->getRequestOk();

        $this->assertEquals('/6b7l9YbkDHDOzOKUFNqBVaPjcgm.jpg', $this->crew->getProfilePath());
    }
}
