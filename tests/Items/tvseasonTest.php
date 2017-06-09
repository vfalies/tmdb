<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;

/**
 * @cover TVSeason
 */
class TVSeasonTest extends TestCase
{

    protected $tmdb          = null;
    protected $tvseason      = null;
    protected $tv_id         = 11;
    protected $season_number = 1;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestTVSeasonEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals('Season 1', $TVSeason->getName());
    }

    /**
     * @test
     */
    public function testGetNameEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEmpty($TVSeason->getName());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertStringStartsWith('Trouble is brewing in the Seven Kingdoms of Westeros', $TVSeason->getOverview());
    }

    /**
     * @test
     */
    public function testGetOverviewEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEmpty($TVSeason->getOverview());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(3624, $TVSeason->getId());
    }

    /**
     * @test
     */
    public function testGetIdEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(0, $TVSeason->getId());
    }

    /**
     * @test
     */
    public function testGetAirDate()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals("2011-04-17", $TVSeason->getAirDate());
    }

    /**
     * @test
     */
    public function testGetAirDateEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals('', $TVSeason->getAirDate());
    }

    /**
     * @test
     */
    public function testGetSeasonNumber()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(1, $TVSeason->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetSeasonNumberEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(0, $TVSeason->getSeasonNumber());
    }

    /**
     * @test
     */
    public function testGetEpisodesCount()
    {
        $this->setRequestOk();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(10, $TVSeason->getEpisodeCount());
    }

    /**
     * @test
     */
    public function testGetEpisodesCountEmpty()
    {
        $this->setRequestTVSeasonEmpty();

        $TVSeason = new TVSeason($this->tmdb, $this->tv_id, $this->season_number);

        $this->assertEquals(0, $TVSeason->getEpisodeCount());
    }

}