<?php

namespace vfalies\tmdb;

class TmdbTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        if (!extension_loaded('curl'))
        {
            $this->markTestSkipped('cUrl extension is not loaded');
        }
    }

    /**
     * @test
     */
    public function testCheckOptionsOk()
    {
        $tmdb = new Tmdb('fake_api_key');
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
     * @expectedException \TypeError
     */
    public function testCheckOptionsYearNOK()
    {
        $tmdb = new Tmdb('fake_api_key');
        $tmdb->checkOptions(array('year' => 'abcd'));
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testCheckOptionsLanguageNOK()
    {
        $tmdb = new Tmdb('fake_api_key');
        $tmdb->checkOptions(array('language' => 'fr'));
    }

    /**
     * @test
     */
    public function testGetConfigurationOK()
    {
        $tmdb = new Tmdb('fake_api_key');
        $tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $tmdb->method('sendRequest')->willReturn($json_object);

        $conf = $tmdb->getConfiguration();

        $this->assertInstanceOf(\stdClass::class, $conf);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetConfigurationNOK()
    {
        $tmdb = new Tmdb('fake_api_key');
        $tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();

        $tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        $tmdb->getConfiguration();
    }

    /**
     * @test
     * @covers \vfalies\tmdb\Tmdb::sendRequest
     * @expectedException \Exception
     * @expectedExceptionCode 1005
     */
    public function testSendRequestHttpError()
    {
        $tmdb = new Tmdb('fake_api_key');
        $tmdb->sendRequest(new CurlRequest(), 'fake/');
    }

    /**
     * @test
     * @covers \vfalies\tmdb\Tmdb::sendRequest
     * @expectedException \Exception
     */
    public function testSendRequestExecError()
    {
        $tmdb = new Tmdb('fake_api_key');
        $tmdb->base_api_url = 'invalid_url';
        $tmdb->sendRequest(new CurlRequest(), 'action');
    }

    /**
     * @test
     * @covers \vfalies\tmdb\Tmdb::sendRequest
     * @expectedException \Exception
     * @expectedExceptionCode 1006
     */
    public function testSendRequestHttpError429()
    {
        $tmdb = new Tmdb('fake_api_key');
        $http_request = $this->getMockBuilder(\vfalies\tmdb\CurlRequest::class)
        ->setMethods(['getInfo'])
        ->getMock();
        $http_request->method('getInfo')->willReturn(429);

        $tmdb->sendRequest($http_request, 'action');
    }

    /**
     * @test
     * @covers \vfalies\tmdb\Tmdb::sendRequest
     * @expectedException \Exception
     * @expectedExceptionCode 2001
     */
    public function testSendRequestHttpErrorNotJson()
    {
        $tmdb = new Tmdb('fake_api_key');
        $http_request = $this->getMockBuilder(\vfalies\tmdb\CurlRequest::class)
        ->setMethods(['getInfo','execute'])
        ->getMock();
        $http_request->method('getInfo')->willReturn(200);
        $http_request->method('execute')->willReturn('Not JSON');

        $tmdb->sendRequest($http_request, 'action');

    }

    /**
     * @test
     * @covers \vfalies\tmdb\Tmdb::sendRequest
     */
    public function testSendRequestOk()
    {
        $tmdb = new Tmdb('fake_api_key');
        $http_request = $this->getMockBuilder(\vfalies\tmdb\CurlRequest::class)
        ->setMethods(['getInfo','execute'])
        ->getMock();
        $http_request->method('getInfo')->willReturn(200);
        $http_request->method('execute')->willReturn(file_get_contents('tests/json/configurationOk.json'));

        $result = $tmdb->sendRequest($http_request, '/test', 'param=1');

        $this->assertInstanceOf(\stdClass::class, $result);
    }
}
