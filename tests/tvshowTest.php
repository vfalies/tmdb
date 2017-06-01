<?php

namespace Vfac\Tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Movie
 */
class TVShowTest extends TestCase
{

    protected $tmdb  = null;
    protected $tv_id = 1;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testContructFailure()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new TVShow($this->tmdb, $this->tv_id);
    }

    /**
     * @test
     */
    public function testGetBackdrop()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetGenres()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetNumberEpisodes()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetNumberSeasons()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetPoster()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetStatus()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

}
