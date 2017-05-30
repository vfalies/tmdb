<?php

namespace Vfac\Tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Movie
 */
class TVShowTest extends TestCase
{

    protected $tmdb    = null;
    protected $result = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\Vfac\Tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchTVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search        = new \Vfac\Tmdb\Search($this->tmdb);
        $this->result = $search->searchTVShow('star trek', array('language' => 'fr-FR'))->current();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->assertInternalType('int', $this->result->getId());
        $this->assertEquals(253, $this->result->getId());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->assertInternalType('string', $this->result->getOverview());
        $this->assertStringStartsWith('Star Trek, ou Patrouille du cosmos au Québec et au Nouveau-Brunswick', $this->result->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->assertInternalType('string', $this->result->getReleaseDate());
        $this->assertEquals('1966-09-08', $this->result->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->assertInternalType('string', $this->result->getOriginalTitle());
        $this->assertEquals('Star Trek', $this->result->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->assertInternalType('string', $this->result->getTitle());
        $this->assertEquals('Star Trek', $this->result->getTitle());
    }

    /**
     * @test
     */
    public function testGetPoster()
    {
        $this->assertNotFalse(filter_var($this->result->getPoster(), FILTER_VALIDATE_URL));
    }

    /**
     * @test
     */
    public function testGetBackdrop()
    {
        $this->assertNotFalse(filter_var($this->result->getBackdrop(), FILTER_VALIDATE_URL));
    }
}
