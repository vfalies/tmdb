<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class CollectionTest extends TestCase
{
    protected $tmdb          = null;
    protected $collection    = null;
    protected $collection_id = 10;

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
     */
    public function testContructFailure()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \VfacTmdb\Exceptions\TmdbException()));

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        new Collection($this->tmdb, $this->collection_id);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $this->assertEquals('/3/collection/'.$this->collection_id, parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals('Star Wars - Saga', $collection->getName());
    }

    /**
     * @test
     */
    public function testGetNameFailure()
    {
        $this->setRequestCollectionEmpty();

        $this->expectException(\Exception::class);
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

        $this->assertIsInt($collection->getId());
        $this->assertEquals($this->collection_id, $collection->getId());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $this->assertIsString($collection->getPosterPath());
        $this->assertNotEmpty($collection->getPosterPath());
    }

    /**
     * @test
     */
    public function testGetPosterPathFailure()
    {
        $this->setRequestCollectionEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);

        $this->assertIsString($collection->getPosterPath());
        $this->assertEmpty($collection->getPosterPath());
    }

    /**
     * @test
     */
    public function testGetParts()
    {
        $this->setRequestOk();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $parts      = $collection->getParts();

        $this->assertInstanceOf(\Generator::class, $parts);
        //$this->assertInstanceOf(\VfacTmdb\Results\Movie::class, $parts->current());

        foreach ($parts as $part) {
            $this->assertInstanceOf(\VfacTmdb\Results\Movie::class, $part);
        }
    }

    /**
     * test
     */
    public function testGetPartsEmpty()
    {
        $this->setRequestCollectionEmpty();

        $collection = new Collection($this->tmdb, $this->collection_id);
        $parts      = $collection->getParts();

        $this->assertInstanceOf(\Generator::class, $parts);
        $this->assertNull($parts->current());
    }

    public function testGetBackdrops()
    {
        $collection = new Collection($this->tmdb, $this->collection_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $backdrops = $collection->getBackdrops();

        $this->assertInstanceOf(\Generator::class, $backdrops);

        foreach ($backdrops as $b) {
            $this->assertEquals('/3/collection/'.$this->collection_id.'/images', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Image::class, $b);
        }
    }

    public function testGetPosters()
    {
        $collection = new Collection($this->tmdb, $this->collection_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $posters = $collection->getPosters();

        $this->assertInstanceOf(\Generator::class, $posters);

        foreach ($posters as $p) {
            $this->assertEquals('/3/collection/'.$this->collection_id.'/images', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Image::class, $p);
        }
    }
}
