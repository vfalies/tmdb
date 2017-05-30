<?php

namespace Vfac\Tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Movie
 */
class MovieTest extends TestCase
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

        $json_object = json_decode(file_get_contents('tests/json/searchMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search        = new \Vfac\Tmdb\Search($this->tmdb);
        $this->result = $search->searchMovie('star wars', array('language' => 'fr-FR'))->current();
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
        $this->assertEquals(11, $this->result->getId());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->assertInternalType('string', $this->result->getOverview());
        $this->assertStringStartsWith('Il y a bien longtemps, dans une galaxie très lointaine...', $this->result->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->assertInternalType('string', $this->result->getReleaseDate());
        $this->assertEquals('1977-05-25', $this->result->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->assertInternalType('string', $this->result->getOriginalTitle());
        $this->assertEquals('Star Wars', $this->result->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->assertInternalType('string', $this->result->getTitle());
        $this->assertEquals('La Guerre des étoiles', $this->result->getTitle());
    }

    /**
     * @test
     */
    public function testGetPoster()
    {
        var_dump($this->result);
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
