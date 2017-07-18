<?php

namespace vfalies\tmdb\Results;

use PHPUnit\Framework\TestCase;

/**
 * @cover PeopleMovieCast
 */
class PeopleMovieCastTest extends TestCase
{

    protected $tmdb          = null;
    protected $result        = null;
    protected $people_id         = 66633;
    protected $moviecast = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
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

        $People      = new \vfalies\tmdb\Items\People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleMovieCreditOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $this->moviecast = $People->getMoviesCast()->current();
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->sendRequestOk();

        $this->assertInternalType('int',$this->moviecast->getId());
        $this->assertEquals(239459,$this->moviecast->getId());
    }

    /**
     * @test
     */
    public function getCreditId()
    {
        $this->sendRequestOk();

        $this->assertEquals('52fe4e93c3a36847f8299dff',$this->moviecast->getCreditId());
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->sendRequestOk();

        $this->assertEquals('No Half Measures: Creating the Final Season of Breaking Bad',$this->moviecast->getTitle());
    }

    /**
     * @test
     */
    public function testGetOriginalTitle()
    {
        $this->sendRequestOk();

        $this->assertEquals('No Half Measures: Creating the Final Season of Breaking Bad',$this->moviecast->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetCharacter()
    {
        $this->sendRequestOk();

        $this->assertEquals('Himself',$this->moviecast->getCharacter());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->sendRequestOk();

        $this->assertEquals('2013-11-26',$this->moviecast->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetAdult()
    {
        $this->sendRequestOk();

        $this->assertEquals(false,$this->moviecast->getAdult());
    }

    /**
     * @test
     */
    public function testGetPosterPath()
    {
        $this->sendRequestOk();

        $this->assertEquals('/8OixSR45U5dbqv8F0tlspmTbXxN.jpg',$this->moviecast->getPosterPath());
    }

}
