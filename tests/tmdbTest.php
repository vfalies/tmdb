<?php

namespace vfalies\tmdb;
use vfalies\tmdb\TmdbException;

class TmdbTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testCheckOptionsOk()
    {
        $tmdb = new Tmdb('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]));
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
        $tmdb = new Tmdb('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]));
        $tmdb->checkOptions(array('language' => 'fr'));
    }

    /**
     * @test
     */
    public function testGetConfigurationOK()
    {
        $tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $tmdb->method('sendRequest')->willReturn($json_object);

        $conf = $tmdb->getConfiguration();

        $this->assertInstanceOf(\stdClass::class, $conf);
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\TmdbException
     */
    public function testGetConfigurationNOK()
    {
        $tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest'])
                ->getMock();

        $tmdb->method('sendRequest')->will($this->throwException(new TmdbException()));

        $tmdb->getConfiguration();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testSendRequestHttpError()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]));
        $tmdb->sendRequest($http_request, 'fake/');
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testSendRequestExecError()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]));
        $tmdb->base_api_url = 'invalid_url';
        $tmdb->sendRequest($http_request, 'action');
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testSendRequestHttpErrorNotJson()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $guzzleclient->method('getBody')->willReturn('Not JSON');

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]));
        $tmdb->sendRequest($http_request, 'action');

    }

    /**
     * @test
     */
    public function testSendRequestOk()
    {
        $tmdb = new Tmdb('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]));

        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\vfalies\tmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse'])
        ->getMock();

        $guzzleclient->method('getBody')->willReturn(file_get_contents('tests/json/configurationOk.json'));
        $http_request->method('getResponse')->willReturn($guzzleclient);

        $result = $tmdb->sendRequest($http_request, '/test', 'param=1');

        $this->assertInstanceOf(\stdClass::class, $result);
    }
}
