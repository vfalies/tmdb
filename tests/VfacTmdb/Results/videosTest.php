<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class VideosTest extends TestCase
{
    protected $tmdb          = null;
    protected $result        = null;
    protected $movie_id      = 550;
    protected $videos        = null;

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

        $json_object = json_decode(file_get_contents('tests/json/videosOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Movie      = new \VfacTmdb\Items\Movie($this->tmdb, $this->movie_id);

        $this->videos = $Movie->getVideos()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/movie/'.$this->movie_id.'/videos', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertEquals('533ec654c3a36854480003eb', $this->videos->getId());
    }

    /**
    * @test
    */
    public function testgetIso_639_1()
    {
        $this->getRequestOk();

        $this->assertEquals('en', $this->videos->getIso_639_1());
    }

    /**
     * @test
     */
    public function testgetIso_3166_1()
    {
        $this->getRequestOk();

        $this->assertEquals('US', $this->videos->getIso_3166_1());
    }

    /**
     * @test
     */
    public function testgetKey()
    {
        $this->getRequestOk();

        $this->assertEquals('SUXWAEX2jlg', $this->videos->getKey());
    }

    /**
     * @test
     */
    public function testgetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Trailer 1', $this->videos->getName());
    }

    /**
     * @test
     */
    public function testgetSite()
    {
        $this->getRequestOk();

        $this->assertEquals('YouTube', $this->videos->getSite());
    }

    /**
     * @test
     */
    public function testgetSize()
    {
        $this->getRequestOk();

        $this->assertEquals(720, $this->videos->getSize());
    }

    /**
     * @test
     */
    public function testgetType()
    {
        $this->getRequestOk();

        $this->assertEquals('Trailer', $this->videos->getType());
    }
}
