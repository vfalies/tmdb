<?php

namespace vfalies\tmdb;

class curlRequestTest extends \PHPUnit_Framework_TestCase
{
    protected $curl = null;

    protected function setUp()
    {
        if ( ! extension_loaded('curl'))
        {
            $this->markTestSkipped('cUrl extension is not loaded');
        }

        $this->curl = new CurlRequest();
    }

    /**
     * @test
     */
    public function testSetUrl()
    {
        $this->curl->setUrl('http://test');
        $this->assertTrue(is_resource($this->curl->handle));
        $this->assertEquals('curl', get_resource_type($this->curl->handle));
    }

    /**
     * @test
     */
    public function testSetOptionOk()
    {
        $this->curl->setUrl('http://www.google.fr');
        $response = $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->assertInstanceOf(Interfaces\HttpRequestInterface::class, $response);
    }

    /**
     * @test
     */
    public function testExecuteOk()
    {
        $this->curl->setUrl('http://www.google.fr');
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->execute();

        $http_code = $this->curl->getInfo(CURLINFO_HTTP_CODE);

        $this->assertEquals(200, $http_code);

        $infos = $this->curl->getInfo();

        $this->assertNotEmpty($infos);

        $this->curl->close();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testExecuteNok()
    {
        $this->curl->setUrl('http://fakeurl.domain');
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->execute();
        $this->curl->close();
    }
}
