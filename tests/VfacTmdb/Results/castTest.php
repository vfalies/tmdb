<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class CastTest extends TestCase
{
    protected $tmdb          = null;
    protected $result        = null;
    protected $movie_id      = 550;
    protected $cast          = null;

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

        $json_object = json_decode(file_get_contents('tests/json/creditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Movie      = new \VfacTmdb\Items\Movie($this->tmdb, $this->movie_id);

        $this->cast = $Movie->getCast()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/movie/'.$this->movie_id.'/credits', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->cast->getId());
        $this->assertEquals(819, $this->cast->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->getRequestOk();

        $this->assertEquals('52fe4250c3a36847f80149f3', $this->cast->getCreditId());
    }

    /**
     * @test
     */
    public function testGetCharacter()
    {
        $this->getRequestOk();

        $this->assertEquals('The Narrator', $this->cast->getCharacter());
    }

    /**
     * @test
     */
    public function testGetGender()
    {
        $this->getRequestOk();

        $this->assertEquals(2, $this->cast->getGender());
    }

    /**
     * @test
     */
    public function testGetOrder()
    {
        $this->getRequestOk();

        $this->assertEquals(0, $this->cast->getOrder());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Edward Norton', $this->cast->getName());
    }

    /**
     * @test
     */
    public function testGetProfilePath()
    {
        $this->getRequestOk();

        $this->assertEquals('/eIkFHNlfretLS1spAcIoihKUS62.jpg', $this->cast->getProfilePath());
    }
}
