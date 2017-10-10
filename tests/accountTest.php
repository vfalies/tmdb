<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\Account\Rated;
use vfalies\tmdb\Account\Favorite;
use vfalies\tmdb\Account\WatchList;
use vfalies\tmdb\Exceptions\ServerErrorException;
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
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    public function createSession()
    {
        $json_object = json_decode(file_get_contents('tests/json/sessionOk.json'));
        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn($json_object);

        $this->auth = new Auth($this->tmdb);
        $this->auth->createSession();
    }

    public function testGetId()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals('/3/account', parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals(548, $account->getId());
    }

    /**
     * @expectedException \vfalies\tmdb\Exceptions\ServerErrorException
     */
    public function testConstructorFailed()
    {
        $account = new Account($this->tmdb, new Auth($this->tmdb));
    }

    public function testGetIdNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getId());
    }

    public function testGetLanguage()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals("en", $account->getLanguage());
    }

    public function testGetLanguageNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getLanguage());
    }

    public function testGetCountry()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals("CA", $account->getCountry());
    }

    public function testGetCountryNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getCountry());
    }

    public function testGetName()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals("Travis Bell", $account->getName());
    }

    public function testGetNameNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getName());
    }


    public function testGetUsername()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals("travisbell", $account->getUsername());
    }

    public function testGetUsernameNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getUsername());
    }

    public function testGetGravatarHash()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals("c9e9fc152ee756a900db85757c29815d", $account->getGravatarHash());
    }

    public function testGetGravatarHashNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getGravatarHash());
    }

    public function testGetIcludeAdult()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEquals(true, $account->getIncludeAdult());
    }

    public function testGetIncludeAdultNok()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountEmptyOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertEmpty($account->getIncludeAdult());
    }

    public function testGetFavorite()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertInstanceOf(Favorite::class, $account->getFavorite());
    }

    public function testGetRated()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertInstanceOf(Rated::class, $account->getRated());
    }

    public function testGetWatchList()
    {
        $this->createSession();

        $this->tmdb->expects($this->at(0))->method('sendRequest')->willReturn(json_decode(file_get_contents('tests/json/accountOk.json')));
        $account = new Account($this->tmdb, $this->auth);

        $this->assertInstanceOf(WatchList::class, $account->getWatchList());
    }
}
