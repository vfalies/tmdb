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

}
