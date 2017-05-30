<?php

namespace Vfac\Tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Collection
 */
class CollectionTest extends TestCase
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

        $json_object = json_decode(file_get_contents('tests/json/searchCollectionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search        = new \Vfac\Tmdb\Search($this->tmdb);
        $this->result = $search->searchCollection('star wars', array('language' => 'fr-FR'))->current();
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
        $this->assertEquals(425281, $this->result->getId());
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetOverview()
    {
        $this->result->getOverview();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetReleaseDate()
    {
        $this->result->getReleaseDate();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetOriginalTitle()
    {
        $this->result->getOriginalTitle();
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->assertInternalType('string', $this->result->getTitle());
        $this->assertEquals('Star Wars: Clone Wars Collection', $this->result->getTitle());
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
