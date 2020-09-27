<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;
use VfacTmdb\Items;

class ItemTest extends TestCase
{
    /**
     * TMDB Object
     * @var Tmdb
     */
    protected $tmdb = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3,new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
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
    public function testGetMovie()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getMovie(11); // Id: 11 => Star Wars

        $this->assertEquals('/3/movie/11', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\Movie::class, $responses);
        $this->assertEquals(11, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetTVShow()
    {
        $json_object = json_decode(file_get_contents('tests/json/TVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getTVShow(253); // Id: 253 => Star Trek

        $this->assertEquals('/3/tv/253', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\TVShow::class, $responses);
        $this->assertEquals(253, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetTVSeason()
    {
        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getTVSeason(253, 1); // Id: 253 => Star Trek

        $this->assertEquals('/3/tv/253/season/1', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\TVSeason::class, $responses);
        $this->assertEquals(3624, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetTVEpisode()
    {
        $json_object = json_decode(file_get_contents('tests/json/TVEpisodeOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getTVEpisode(253, 1, 1); // Id: 253 => Star Trek

        $this->assertEquals('/3/tv/253/season/1/episode/1', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\TVEpisode::class, $responses);
        $this->assertEquals(63056, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetCollection()
    {
        $json_object = json_decode(file_get_contents('tests/json/collectionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getCollection(10); // Id: 10 => Star Wars saga

        $this->assertEquals('/3/collection/10', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\Collection::class, $responses);
        $this->assertEquals(10, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetPeople()
    {
        $json_object = json_decode(file_get_contents('tests/json/peopleOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getPeople(287);

        $this->assertEquals('/3/person/287', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\People::class, $responses);
        $this->assertEquals(287, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetCompany()
    {
        $json_object = json_decode(file_get_contents('tests/json/companyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getCompany(1);

        $this->assertEquals('/3/company/1', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\Company::class, $responses);
        $this->assertEquals(1, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetTVNetwork()
    {
        $json_object = json_decode(file_get_contents('tests/json/TVNetworkOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getTVNetwork(1);

        $this->assertEquals('/3/network/1', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(Items\TVNetwork::class, $responses);
        $this->assertEquals(1, $responses->getId());
    }
}
