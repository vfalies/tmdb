<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
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
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
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
     * @runInSeparateProcess
     */
    public function testConnect()
    {
        $request_token = '991c25974a2fcf3d923ae722f46e9c44788ff3ba';
        $redirect_url  = 'https://vfac.fr';

        $Account = new Account($this->tmdb);
        $Account->connect($request_token, $redirect_url);

        $this->assertContains(
            'Location: https://www.themoviedb.org/authenticate/'.$request_token.'?redirect_to='.$redirect_url, xdebug_get_headers()
        );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testConnectInvalidRediction()
    {
        $request_token = '991c25974a2fcf3d923ae722f46e9c44788ff3ba';
        $redirect_url  = 'vfac.fr';

        $Account = new Account($this->tmdb);
        $Account->connect($request_token, $redirect_url);
    }

    /**
     * @test
     */
    public function testGetRequestToken()
    {
        $json_object = json_decode(file_get_contents('tests/json/requestTokenOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Account = new Account($this->tmdb);
        $request_token = $Account->getRequestToken();

        $this->assertNotEmpty($request_token);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetRequestTokenNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/requestTokenNok.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Account = new Account($this->tmdb);
        $Account->getRequestToken();
    }

    /**
     * @test
     */
    public function testCreateSession()
    {
        $request_token = '991c25974a2fcf3d923ae722f46e9c44788ff3ba';

        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Account = new Account($this->tmdb);
        $session = $Account->createSession($request_token);

        $this->assertNotEmpty($session);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testCreateSessionNok()
    {
        $request_token = '991c25974a2fcf3d923ae722f46e9c44788ff3ba';

        $json_object = json_decode(file_get_contents('tests/json/sessionNok.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Account = new Account($this->tmdb);
        $Account->createSession($request_token);
    }
}
