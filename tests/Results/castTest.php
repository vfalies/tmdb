<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover Cast
 */
class CastTest extends TestCase
{

    protected $tmdb          = null;
    protected $result        = null;
    protected $movie_id      = 550;
    protected $cast          = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function sendRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/creditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $Movie      = new \vfalies\tmdb\Items\Movie($this->tmdb, $this->movie_id);

        $this->cast = $Movie->getCast()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->cast->getId());
        $this->assertEquals(819, $this->cast->getId());
    }

    /**
     * @test
     */
    public function testGetCastId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int', $this->cast->getCastId());
        $this->assertEquals(4, $this->cast->getCastId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->sendRequestOk();

        $this->assertEquals('52fe4250c3a36847f80149f3', $this->cast->getCreditId());
    }

    /**
     * @test
     */
    public function testGetCharacter()
    {
        $this->sendRequestOk();

        $this->assertEquals('The Narrator', $this->cast->getCharacter());
    }

    /**
     * @test
     */
    public function testGetGender()
    {
        $this->sendRequestOk();

        $this->assertEquals(2, $this->cast->getGender());
    }

    /**
     * @test
     */
    public function testGetOrder()
    {
        $this->sendRequestOk();

        $this->assertEquals(0, $this->cast->getOrder());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->sendRequestOk();

        $this->assertEquals('Edward Norton', $this->cast->getName());
    }

    /**
     * @test
     */
    public function testGetProfilePath()
    {
        $this->sendRequestOk();

        $this->assertEquals('/eIkFHNlfretLS1spAcIoihKUS62.jpg', $this->cast->getProfilePath());
    }

}
