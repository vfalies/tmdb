<?php

namespace vfalies\tmdb\lib\Guzzle;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

/**
 * @cover Client
 */
class ClientTest extends TestCase
{

    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['getRequest'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testGetResponseOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $response = $client->getResponse('http://httpbin.org/get');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\Exceptions\HttpErrorException
     */
    public function testGetResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->getResponse('badurl_totally_fake');
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\Exceptions\NotFoundException
     */
    public function testGetResponseNok404()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->getResponse('http://httpstat.us/404');
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\Exceptions\ServerErrorException
     */
    public function testGetResponseNok500()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->getResponse('http://httpstat.us/500');
    }

}
