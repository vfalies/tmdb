<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

class TmdbTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testCheckOptionsOk()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));
        $options = $tmdb->checkOptions(array('year'          => '2014',
            'language'      => 'fr-FR',
            'include_adult' => false,
            'page'          => 2));

        $this->assertArrayHasKey('year', $options);
        $this->assertArrayHasKey('language', $options);
        $this->assertArrayHasKey('include_adult', $options);
        $this->assertArrayHasKey('page', $options);

        $this->assertEquals('2014', $options['year']);
        $this->assertEquals('fr-FR', $options['language']);
        $this->assertEquals(false, $options['include_adult']);
        $this->assertEquals('2', $options['page']);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testCheckOptionsLanguageNOK()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));
        $tmdb->checkOptions(array('language' => 'fr'));
    }

    /**
     * @test
     */
    public function testGetConfigurationOK()
    {
        $tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['getRequest'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $tmdb->method('getRequest')->willReturn($json_object);

        $conf = $tmdb->getConfiguration();

        $this->assertInstanceOf(\stdClass::class, $conf);
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\Exceptions\TmdbException
     */
    public function testGetConfigurationNOK()
    {
        $tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['getRequest'])
                ->getMock();

        $tmdb->method('getRequest')->will($this->throwException(new TmdbException()));

        $tmdb->getConfiguration();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testgetRequestHttpError()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);
        $tmdb->getRequest('fake/');
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testgetRequestExecError()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);
        $tmdb->base_api_url = 'invalid_url';
        $tmdb->getRequest('action');
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testgetRequestHttpErrorNotJson()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $guzzleclient->method('getBody')->willReturn('Not JSON');

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);
        $tmdb->getRequest('action');
    }

    /**
     * @test
     */
    public function testgetRequestOk()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);

        $guzzleclient->method('getBody')->willReturn(file_get_contents('tests/json/configurationOk.json'));
        $http_request->method('getResponse')->willReturn($guzzleclient);

        $result = $tmdb->getRequest('/test', ['param=1']);

        $this->assertInstanceOf(\stdClass::class, $result);
    }
}
