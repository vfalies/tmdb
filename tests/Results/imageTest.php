<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Image
 */
class ImageTest extends TestCase
{

    protected $tmdb   = null;
    protected $result = null;
    protected $collection_id = 10;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function sendRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $collection = new Collection($this->tmdb, $this->collection_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->result = $collection->getBackdrops();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->result->getId());
        $this->assertEquals(11, $this->result->getId());
    }

    /**
     * @test
     */
    public function testContructFailed()
    {
        $result = new \stdClass();
        $result->not_property = 'test';

        new \vfalies\tmdb\Results\Image($this->tmdb, $result);
    }

    /**
     * @test
     */
    public function testGetAspectRatio()
    {
        $this->sendRequestOk();

        $this->assertInternalType('double', $this->result[0]->getAspectRatio());
        $this->assertEquals(1.77777777777778, $this->result[0]->getAspectRatio());
    }

}
