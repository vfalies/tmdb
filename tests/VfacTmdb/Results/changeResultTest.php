<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class ChangeResultTest extends TestCase
{
    protected $tmdb   = null;
    protected $result = null;

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

    private function getRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/changesMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $change       = new \VfacTmdb\Change($this->tmdb);
        $this->result = $change->movie()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertIsInt($this->result->getId());
        $this->assertEquals(659860, $this->result->getId());
    }

    /**
     * @test
     */
    public function testGetAdult()
    {
        $this->getRequestOk();

        $this->assertIsBool($this->result->getAdult());
        $this->assertFalse($this->result->getAdult());
    }
}
