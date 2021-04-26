<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Account\Rated;
use VfacTmdb\Account\Favorite;
use VfacTmdb\Account\WatchList;
use VfacTmdb\Exceptions\ServerErrorException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class AccountTest extends TestCase
{
    /**
     * @var MockObject
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

    public function createSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));

        $this->tmdb->method('sendRequest')->willReturn($json_object);


        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        return $session_id;
    }

    public function testGetId()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals('/3/account', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals(548, $account->getId());
    }

    public function testConstructorFailedAccountDetails()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountEmptyOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $this->expectException(\VfacTmdb\Exceptions\ServerErrorException::class);
        $account = new Account($this->tmdb, $session_id);
    }

    public function testGetLanguage()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals("en", $account->getLanguage());
    }

    public function testGetCountry()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals("CA", $account->getCountry());
    }

    public function testGetName()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals("Travis Bell", $account->getName());
    }

    public function testGetUsername()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals("travisbell", $account->getUsername());
    }

    public function testGetGravatarHash()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals("c9e9fc152ee756a900db85757c29815d", $account->getGravatarHash());
    }

    public function testGetIcludeAdult()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertEquals(true, $account->getIncludeAdult());
    }

    public function testGetFavorite()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertInstanceOf(Favorite::class, $account->getFavorite());
    }

    public function testGetRated()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertInstanceOf(Rated::class, $account->getRated());
    }

    public function testGetWatchList()
    {
        $sessionOk       = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $configurationOk = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $accountOk       = json_decode(file_get_contents('tests/json/accountOk.json'));

        $this->tmdb->method('sendRequest')
                   ->will($this->onConsecutiveCalls(
                       $sessionOk,
                       $configurationOk,
                       $accountOk
                   ));

        $this->auth = new Auth($this->tmdb);
        $session_id = $this->auth->createSession('991c25974a2fcf3d923ae722f46e9c44788ff3ea');

        $account = new Account($this->tmdb, $session_id);

        $this->assertInstanceOf(WatchList::class, $account->getWatchList());
    }
}
