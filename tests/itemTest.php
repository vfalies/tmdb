<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

class ItemTest extends TestCase
{
    /**
     * TMDB Object
     * @var Tmdb
     */
    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3,new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['getRequest'])
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
    public function testGetMovie()
    {
        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getMovie(11); // Id: 11 => Star Wars

        $this->assertInstanceOf(Items\Movie::class, $responses);
        $this->assertEquals(11, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetTVShow()
    {
        $json_object = json_decode(file_get_contents('tests/json/TVShowOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getTVShow(253); // Id: 253 => Star Trek

        $this->assertInstanceOf(Items\TVShow::class, $responses);
        $this->assertEquals(253, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetCollection()
    {
        $json_object = json_decode(file_get_contents('tests/json/collectionOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getCollection(10); // Id: 10 => Star Wars saga

        $this->assertInstanceOf(Items\Collection::class, $responses);
        $this->assertEquals(10, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetPeople()
    {
        $json_object = json_decode(file_get_contents('tests/json/peopleOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getPeople(287);

        $this->assertInstanceOf(Items\People::class, $responses);
        $this->assertEquals(287, $responses->getId());
    }

    /**
     * @test
     */
    public function testGetCompany()
    {
        $json_object = json_decode(file_get_contents('tests/json/companyOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $get       = new Item($this->tmdb);
        $responses = $get->getCompany(1);

        $this->assertInstanceOf(Items\Company::class, $responses);
        $this->assertEquals(1, $responses->getId());
    }
}
