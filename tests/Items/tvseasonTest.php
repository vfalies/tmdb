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

    private function setRequestMovieEmpty()
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

}
