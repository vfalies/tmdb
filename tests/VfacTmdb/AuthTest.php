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

        $this->tmdb->method('sendRequest')->willReturn($this->createRequestTokenValid());

        $Auth = new Auth($this->tmdb);
        $Auth->connect($redirect_url);

        $this->assertEquals('/3/authentification/token/new', parse_url($this->tmdb->url, PHP_URL_PATH));

        if (!function_exists('xdebug_get_headers')) {
            $this->markTestSkipped('XDebug not available on the system');
        }
        $this->assertContains(
            'Location: https://www.themoviedb.org/authenticate/'.$Auth->request_token.'?redirect_to='.$redirect_url,
            xdebug_get_headers()
        );
    }

    /**
     * @test
     * @expectedException \VfacTmdb\Exceptions\IncorrectParamException
     */
    public function testConnectInvalidRedirection()
    {
        $redirect_url  = 'vfac.fr';

        $this->tmdb->method('sendRequest')->willReturn($this->createRequestTokenValid());

        $Auth = new Auth($this->tmdb);
        $Auth->connect($redirect_url);
    }

    /**
     * @test
     * @expectedException \VfacTmdb\Exceptions\InvalidResponseException
     */
    public function testConnectInvalidRequestToken()
    {
        $json_object = json_decode(file_get_contents('tests/json/requestTokenNok.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Auth = new Auth($this->tmdb);
        $Auth->connect();
    }

    /**
     * @test
     */
    public function testCreateSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Auth = new Auth($this->tmdb);
        $Auth->createSession();

        $this->assertEquals('/3/authentification/session/new', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertNotEmpty($Auth->session_id);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testCreateSessionNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionNok.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Auth = new Auth($this->tmdb);
        $Auth->createSession();
    }

    /**
     * @test
     * @expectedException \VfacTmdb\Exceptions\NotFoundException
     */
    public function testMagicalGet()
    {
        $Auth = new Auth($this->tmdb);
        $Auth->unknown;
    }
}