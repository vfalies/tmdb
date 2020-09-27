<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class PeopleTVShowCastTest extends TestCase
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

        $json_object = json_decode(file_get_contents('tests/json/PeopleTVShowCreditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->moviecast = $People->getTVShowCast()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/person/'.$this->people_id.'/tv_credits', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->moviecast->getId());
        $this->assertEquals(18347, $this->moviecast->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->getRequestOk();

        $this->assertEquals('5328ddb6c3a3683d430006a7', $this->moviecast->getCreditId());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertEquals('Community', $this->moviecast->getName());
    }

    /**
     * @test
     */
    public function testGetOriginalName()
    {
        $this->getRequestOk();

        $this->assertEquals('Community', $this->moviecast->getOriginalName());
    }

    /**
     * @test
     */
    public function testGetCharacter()
    {
        $this->getRequestOk();

        $this->assertEquals('Devon', $this->moviecast->getCharacter());
    }

    /**
     * @test
     */
    public function testGetFirstAirDate()
    {
        $this->getRequestOk();

        $this->assertEquals('2009-09-17', $this->moviecast->getFirstAirDate());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->getRequestOk();

        $this->assertEquals('/kMceNzAgVtl6MwU5C7Iv9azPbih.jpg', $this->moviecast->getPosterPath());
    }

    /**
     * @test
     */
    public function testGetEpisodeCount()
    {
        $this->getRequestOk();

        $this->assertEquals(1, $this->moviecast->getEpisodeCount());
    }
}
