<?php

namespace VfacTmdb\lib\Guzzle;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Tmdb;
use VfacTmdb\lib\Guzzle\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ClientTest extends TestCase
{
    protected $tmdb = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
                ->getMock();
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function mockResponseStatus($status)
    {
        $mock = new MockHandler([
            new Response($status, ['X-Foo' => 'Bar'], 'Hello, World')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        return $guzzleClient;
    }

    /**
     * @test
     */
    public function testGetResponseOk()
    {
        $guzzleClient = $this->mockResponseStatus(200);

        $client   = new Client($guzzleClient);
        $response = $client->getResponse('/');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testGetResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $this->expectException(\Exception::class);
        $client   = new Client($guzzleClient);
        $client->getResponse('badurl_totally_fake');
    }

    /**
     * @test
     */
    public function testGetResponseNok404()
    {
        $guzzleClient = $this->mockResponseStatus(404);

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        $client   = new Client($guzzleClient);
        $client->getResponse('/');
    }

    /**
     * @test
     */
    public function testGetResponseNok500()
    {
        $guzzleClient = $this->mockResponseStatus(500);

        $this->expectException(\VfacTmdb\Exceptions\ServerErrorException::class);
        $client   = new Client($guzzleClient);
        $client->getResponse('/');
    }


    /**
     * @test
     */
    public function testPostResponseOk()
    {
        $guzzleClient = $this->mockResponseStatus(200);

        $client   = new Client($guzzleClient);
        $response = $client->postResponse('/');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testPostResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $this->expectException(\Exception::class);
        $client   = new Client($guzzleClient);
        $client->postResponse('badurl_totally_fake');
    }

    /**
     * @test
     */
    public function testPostResponseNok404()
    {
        $guzzleClient = $this->mockResponseStatus(404);

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        $client   = new Client($guzzleClient);
        $client->postResponse('/');
    }

    /**
     * @test
     */
    public function testPostResponseNok500()
    {
        $guzzleClient = $this->mockResponseStatus(500);

        $this->expectException(\VfacTmdb\Exceptions\ServerErrorException::class);
        $client   = new Client($guzzleClient);
        $client->postResponse('/');
    }

    /**
     * @test
     */
    public function testDeleteResponseOk()
    {
        $guzzleClient = $this->mockResponseStatus(200);

        $client   = new Client($guzzleClient);
        $response = $client->postResponse('/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testDeleteResponseNOk()
    {
        $guzzleClient = new \GuzzleHttp\Client();

        $this->expectException(\Exception::class);
        $client   = new Client($guzzleClient);
        $client->deleteResponse('badurl_totally_fake');
    }

    /**
     * @test
     */
    public function testDeleteResponseNok404()
    {
        $guzzleClient = $this->mockResponseStatus(404);

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        $client   = new Client($guzzleClient);
        $client->deleteResponse('/');
    }

    /**
     * @test
     */
    public function testDeleteResponseNok500()
    {
        $guzzleClient = $this->mockResponseStatus(500);

        $this->expectException(\VfacTmdb\Exceptions\ServerErrorException::class);
        $client   = new Client($guzzleClient);
        $client->deleteResponse('/');
    }
}
