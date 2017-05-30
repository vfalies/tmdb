<?php

namespace Vfac\Tmdb;

class TmdbTest extends \PHPUnit_Framework_TestCase
{

    protected $tmdb;

    public function setUp()
    {
        parent::setUp();
        $this->tmdb = new Tmdb('fake_api_key');
    }

    /**
     * @test
     */
    public function testCheckOptionsOk()
    {
        $options = $this->tmdb->checkOptions(array('year'          => '2014',
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
        $this->tmdb->checkOptions(array('year' => 'abcd'));
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testCheckOptionsLanguageNOK()
    {
        $this->tmdb->checkOptions(array('language' => 'fr'));
    }

    /**
     * @test
     */
    public function testGetConfigurationOK()
    {
        $this->tmdb = $this->getMockBuilder(\Vfac\Tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $conf = $this->tmdb->getConfiguration();

        $this->assertInstanceOf(\stdClass::class, $conf);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetConfigurationNOK()
    {
        $this->tmdb = $this->getMockBuilder(\Vfac\Tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();

        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        $this->tmdb->getConfiguration();
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionCode 1005
     */
    public function testSendRequestHttpError()
    {
        $this->tmdb->sendRequest('fake/');
    }

}
