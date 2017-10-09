<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

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
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
                ->getMock();

        $this->createSession();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function createSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn($json_object);

        $this->auth = new Auth($this->tmdb);
        $this->auth->createSession();
    }

    public function testGetId()
    {
        $this->tmdb->expects($this->at(1))->method('sendRequest')->willReturn(file_get_contents('tests/json/accountOk.json'));
        $this->markTestIncomplete();
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals('/3/account', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals(548, $account->getId());
    }
}
