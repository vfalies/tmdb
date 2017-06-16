<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Media
 */
class MediaTest extends TestCase
{

    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('vfalies\Tmdb')))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testUrl()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $path = "/yVaQ34IvVDAZAWxScNdeIkaepDq.jpg";

        $media = new Media($this->tmdb);

        $url = $media->getBackdropUrl($path);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));

        $url = $media->getPosterUrl($path);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));

        $url = $media->getLogoUrl($path);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));

        $url = $media->getProfileUrl($path);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));

        $url = $media->getStillUrl($path);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\Exceptions\NotFoundException
     */
    public function testUrlNotFound()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $path = "/yVaQ34IvVDAZAWxScNdeIkaepDq.jpg";

        $media = new Media($this->tmdb);
        $media->getBackdropUrl($path);
    }

    /**
     * @test
     * @expectedException vfalies\tmdb\Exceptions\IncorrectParamException
     */
    public function testUrlIncorrectParam()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $path = "/yVaQ34IvVDAZAWxScNdeIkaepDq.jpg";

        $media = new Media($this->tmdb);
        $media->getBackdropUrl($path, 'incorrectsize');
    }

}
