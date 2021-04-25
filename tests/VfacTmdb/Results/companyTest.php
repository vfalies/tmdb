<?php

namespace VfacTmdb\Results;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class CompanyTest extends TestCase
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
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchCompanyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \VfacTmdb\Search($this->tmdb);
        $this->result = $search->company('lucasfilm', array('language' => 'fr-FR'))->current();
    }

    private function getRequestConfNok()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/searchCompanyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search       = new \VfacTmdb\Search($this->tmdb);
        $this->result = $search->company('lucasfilm', array('language' => 'fr-FR'))->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->getRequestOk();

        $this->assertEquals('/3/search/company', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertIsInt($this->result->getId());
        $this->assertEquals(1, $this->result->getId());
    }

    /**
     * @test
     */
    public function testContructFailed()
    {
        $result = new \stdClass();
        $result->not_property = 'test';

        $this->expectException(\VfacTmdb\Exceptions\NotFoundException::class);
        new \VfacTmdb\Results\Movie($this->tmdb, $result);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->getRequestOk();

        $this->assertIsString($this->result->getName());
        $this->assertEquals('Lucasfilm', $this->result->getName());
    }

    /**
     * @test
     */
    public function testGetLogoPath()
    {
        $this->getRequestOk();

        $this->assertIsString($this->result->getLogoPath());
        $this->assertEquals('/8rUnVMVZjlmQsJ45UGotD0Uznxj.png', $this->result->getlogoPath());
    }
}
