<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover TVSeason
 */
class TVSeasonTest extends TestCase
{

    protected $tmdb   = null;
    protected $result = null;
    protected $tv_id  = 253;
    protected $season = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function sendRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $TVShow       = new \vfalies\tmdb\Items\TVShow($this->tmdb, $this->tv_id);
        $this->season = $TVShow->getSeasons()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->season->getId());
        $this->assertEquals(816, $this->season->getId());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->sendRequestOk();

        $this->assertInternalType('string', $this->season->getReleaseDate());
        $this->assertEquals('1988-10-15', $this->season->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetEpisodeCount()
    {
        $this->sendRequestOk();

        $this->assertEquals(5, $this->season->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->sendRequestOk();

        $this->assertEquals(0, $this->season->getSeasonNumber());
    }

}
