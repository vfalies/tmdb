<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class AuthTest extends TestCase
{
    /**
     * [protected description]
     * @var [type]
     */
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

    /**
     * Create a valid request token simulation
     * @return \stdClass JSON object
     */
    private function createRequestTokenValid()
    {
        $response = new \stdClass();
        $response->success = true;
        $response->expires_at = (new \DateTime())->format('Y-m-d H:i:s e');
        $response->request_token = '991c25974a2fcf3d923ae722f46e9c44788ff3ea';

        return $response;
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function testConnect()
    {
        $redirect_url  = 'https://vfac.fr';
        $request_token = '991c25974a2fcf3d923ae722f46e9c44788ff3ea';

        $Auth = new Auth($this->tmdb);
        $Auth->connect($request_token, $redirect_url);

        if (!function_exists('xdebug_get_headers')) {
            $this->markTestSkipped('XDebug not available on the system');
        }
        $this->assertContains(
            'Location: https://www.themoviedb.org/authenticate/'.$request_token.'?redirect_to='.$redirect_url,
            xdebug_get_headers()
        );
    }

    public function testGetRequestToken()
    {
        $this->tmdb->method('sendRequest')->willReturn($this->createRequestTokenValid());

        $Auth = new Auth($this->tmdb);
        $request_token = $Auth->getRequestToken();

        $this->assertEquals('/3/authentication/token/new', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals('991c25974a2fcf3d923ae722f46e9c44788ff3ea', $request_token);
    }

    /**
     * @test
     */
    public function testConnectInvalidRedirection()
    {
        $redirect_url  = 'invalid_url';

        $this->tmdb->method('sendRequest')->willReturn($this->createRequestTokenValid());

        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $Auth = new Auth($this->tmdb);
        $Auth->connect('991c25974a2fcf3d923ae722f46e9c44788ff3ea', $redirect_url);
    }

    /**
     * @test
     */
    public function testConnectInvalidRequestToken()
    {
        $json_object = json_decode(file_get_contents('tests/json/requestTokenNok.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->expectException(\VfacTmdb\Exceptions\InvalidResponseException::class);
        $Auth = new Auth($this->tmdb);
        $Auth->getRequestToken();
    }

    /**
     * @test
     */
    public function testCreateSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Auth = new Auth($this->tmdb);
        $Auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $this->assertEquals('/3/authentication/session/new', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertNotEmpty($Auth->session_id);
    }

    /**
     * @test
     */
    public function testCreateSessionNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionNok.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->expectException(\Exception::class);
        $Auth = new Auth($this->tmdb);
        $Auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');
    }

    /**
     * @test
     */
    public function testMagicalGet()
    {
        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);

        $Auth = new Auth($this->tmdb);
        $Auth->unknown;
    }
}
