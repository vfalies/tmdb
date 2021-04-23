<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class ItemChangeResultTest extends TestCase
{
    protected $tmdb       = null;
    protected $movie_id   = 122095;
    protected $itemChange = null;

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
        $json_object = json_decode(file_get_contents('tests/json/itemChangesMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = new \VfacTmdb\Items\MovieItemChanges($this->tmdb, $this->movie_id);

        $this->itemChange = $itemChanges->getChangesByKey('runtime')->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/movie/'.$this->movie_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertEquals('607f6df3c390c500585f274a', $this->itemChange->getId());
    }

    /**
     * @test
     */
    public function testGetKey()
    {
        $this->getRequestOk();

        $this->assertEquals('runtime', $this->itemChange->getKey());
    }

    /**
     * @test
     */
    public function testGetAction()
    {
        $this->getRequestOk();

        $this->assertEquals('updated', $this->itemChange->getAction());
    }

    /**
     * @test
     */
    public function testGetTime()
    {
        $this->getRequestOk();

        $this->assertInstanceOf(\DateTime::class, $this->itemChange->getTime());
        $this->assertEquals('2021-04-21 00:12:35 UTC', $this->itemChange->getTime()->format('Y-m-d H:i:s e'));
    }

    /**
    * @test
    */
    public function testGetIso_639_1()
    {
        $this->getRequestOk();

        $this->assertEquals('pt', $this->itemChange->getIso_639_1());
    }

    /**
     * @test
     */
    public function testGetIso_3166_1()
    {
        $this->getRequestOk();

        $this->assertEquals('BR', $this->itemChange->getIso_3166_1());
    }

    /**
     * @test
     */
    public function testGetValue()
    {
        $this->getRequestOk();

        $this->assertEquals([80], $this->itemChange->getValue());
    }

    /**
     * @test
     */
    public function testGetOriginalValue()
    {
        $this->getRequestOk();

        $this->assertEquals([0], $this->itemChange->getOriginalValue());
    }
}
