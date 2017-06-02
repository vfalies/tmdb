<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;

/**
 * @cover Movie
 */
class CollectionTest extends TestCase
{

    protected $tmdb          = null;
    protected $collection    = null;
    protected $collection_id = 10;

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

        $json_object = json_decode(file_get_contents('tests/json/collectionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestCollectionEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/collectionEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/collectionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testContructFailure()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new Collection($this->tmdb, $this->collection_id);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $this->assertEquals('Star Wars - Saga', $collection->getName());
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetNameFailure()
    {
        $this->setRequestCollectionEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $collection->getName();
    }

    /**
     * @test
     */
    public function testCollectionId()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $this->assertInternalType('int', $collection->getId());
        $this->assertEquals($this->collection_id, $collection->getId());
    }

    /**
     * @test
     */
    public function testGetPoster()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $this->assertNotFalse(filter_var($collection->getPoster(), FILTER_VALIDATE_URL));
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPosterFailure()
    {
        $this->setRequestCollectionEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $collection->getPoster();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPosterFailureConf()
    {
        $this->setRequestConfigurationEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $collection->getPoster();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPosterFailureSize()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $collection->getPoster('w184');
    }

    /**
     * @test
     */
    public function testGetBackdrop()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $this->assertNotFalse(filter_var($collection->getBackdrop(), FILTER_VALIDATE_URL));
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetBackdropFailure()
    {
        $this->setRequestCollectionEmpty();
        $collection = new Collection($this->tmdb, $this->collection_id);
        $collection->getBackdrop();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetBackdropFailureConf()
    {
        $this->setRequestConfigurationEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $collection->getBackdrop();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetBackdropFailureSize()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $collection->getBackdrop('w184');
    }

    /**
     * @test
     */
    public function testGetParts()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $parts = $collection->getParts();

        $this->assertInstanceOf(\Generator::class, $parts);
        $this->assertInstanceOf(\vfalies\tmdb\Results\Movie::class, $parts->current());
    }

    /**
     * test
     */
    public function testGetPartsEmpty()
    {
        $this->setRequestCollectionEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $parts = $collection->getParts();

        $this->assertInstanceOf(\Generator::class, $parts);
        $this->assertNull($parts->current());
    }
}
