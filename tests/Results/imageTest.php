<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

/**
 * @cover Image
 */
class ImageTest extends TestCase
{
    protected $tmdb          = null;
    protected $result        = null;
    protected $collection_id = 10;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function getRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $collection = new \VfacTmdb\Items\Collection($this->tmdb, $this->collection_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->result = $collection->getBackdrops()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertInternalType('int', $this->result->getId());
        $this->assertEquals(10, $this->result->getId());
    }

    /**
     * @test
     * @expectedException \VfacTmdb\Exceptions\NotFoundException
     */
    public function testContructFailed()
    {
        $result               = new \stdClass();
        $result->not_property = 'test';

        new \VfacTmdb\Results\Image($this->tmdb, 10, $result);
    }

    /**
     * @test
     */
    public function testGetAspectRatio()
    {
        $this->getRequestOk();

        $this->assertInternalType('double', $this->result->getAspectRatio());
        $this->assertEquals(1.77777777777778, $this->result->getAspectRatio());
    }

    /**
     * @test
     */
    public function testGetFilePath()
    {
        $this->getRequestOk();

        $this->assertEquals('/shDFE0i7josMt9IKXdYpnMFFgNV.jpg', $this->result->getFilePath());
    }

    /**
     * @test
     */
    public function testGetHeight()
    {
        $this->getRequestOk();

        $this->assertInternalType('int', $this->result->getHeight());
        $this->assertEquals(1080, $this->result->getHeight());
    }

    /**
     * @test
     */
    public function testGetIso6391()
    {
        $this->getRequestOk();

        $this->assertEquals(null, $this->result->getIso6391());
    }

    /**
     * @test
     */
    public function testGetVoteAverage()
    {
        $this->getRequestOk();

        $this->assertInternalType('double', $this->result->getVoteAverage());
        $this->assertEquals(5.3125, $this->result->getVoteAverage());
    }

    /**
     * @test
     */
    public function testGetVoteCount()
    {
        $this->getRequestOk();

        $this->assertInternalType('int', $this->result->getVoteCount());
        $this->assertEquals(1, $this->result->getVoteCount());
    }

    /**
     * @test
     */
    public function testGetWidth()
    {
        $this->getRequestOk();

        $this->assertInternalType('int', $this->result->getWidth());
        $this->assertEquals(1920, $this->result->getWidth());
    }
}
