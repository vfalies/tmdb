<?php

namespace VfacTmdb\lib\Guzzle;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Tmdb;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class ClientTest extends TestCase
{
    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
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
     * @expectedException VfacTmdb\Exceptions\HttpErrorException
     */
    public function testGetResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->getResponse('badurl_totally_fake');
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\NotFoundException
     */
    public function testGetResponseNok404()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->getResponse('http://httpbin.org/status/404');
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\ServerErrorException
     */
    public function testGetResponseNok500()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->getResponse('http://httpbin.org/status/500');
    }


    /**
     * @test
     */
    public function testPostResponseOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $response = $client->postResponse('http://httpbin.org/post');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\HttpErrorException
     */
    public function testPostResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->postResponse('badurl_totally_fake');
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\NotFoundException
     */
    public function testPostResponseNok404()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->postResponse('http://httpbin.org/status/404');
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\ServerErrorException
     */
    public function testPostResponseNok500()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->postResponse('http://httpbin.org/status/500');
    }

    /**
     * @test
     */
    public function testDeleteResponseOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $response = $client->deleteResponse('http://httpbin.org/delete');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\HttpErrorException
     */
    public function testDeleteResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->deleteResponse('badurl_totally_fake');
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\NotFoundException
     */
    public function testDeleteResponseNok404()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->deleteResponse('http://httpbin.org/status/404');
    }

    /**
     * @test
     * @expectedException VfacTmdb\Exceptions\ServerErrorException
     */
    public function testDeleteResponseNok500()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $client   = new Client($guzzleClient);
        $client->deleteResponse('http://httpbin.org/status/500');
    }
}
