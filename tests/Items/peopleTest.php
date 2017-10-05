<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

/**
 * @cover People
 */
class PeopleTest extends TestCase
{

    protected $tmdb     = null;
    protected $people    = null;
    protected $people_id = 287;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['getRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/peopleOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);
    }

    private function setRequestPeopleEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/peopleEmptyOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/peopleOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testContructFailure()
    {
        $this->tmdb->method('getRequest')->will($this->throwException(new \Exception()));

        new People($this->tmdb, $this->people_id);
    }

    /**
     * @test
     */
    public function testGetAdult()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(false, $people->getAdult());
    }

    /**
     * @test
     */
    public function testGetAdultFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(false, $people->getAdult());
    }

    /**
     * @test
     */
    public function testGetAlsoKnownAs()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals([], $people->getAlsoKnownAs());
    }

    /**
     * @test
     */
    public function testGetAlsoKnownAsFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getAlsoKnownAs());
    }

    /**
     * @test
     */
    public function testGetBiography()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertStringStartsWith('William Bradley ', $people->getBiography());
    }

    /**
     * @test
     */
    public function testGetBiographyFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getBiography());
    }

    /**
     * @test
     */
    public function testGetBirthday()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('1963-12-18', $people->getBirthday());
    }

    /**
     * @test
     */
    public function testGetBirthdayFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getBirthday());
    }

    /**
     * @test
     */
    public function testGetDeathday()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('', $people->getDeathday());
    }

    /**
     * @test
     */
    public function testGetDeathdayFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getDeathday());
    }

    /**
     * @test
     */
    public function testGetGender()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(0, $people->getGender());
    }

    /**
     * @test
     */
    public function testGetGenderFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(0, $people->getGender());
    }

    /**
     * @test
     */
    public function testGetHomepage()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('', $people->getHomepage());
    }

    /**
     * @test
     */
    public function testGetHomepageFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getHomepage());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(287, $people->getId());
    }

    /**
     * @test
     */
    public function testGetIdFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(0, $people->getId());
    }

    /**
     * @test
     */
    public function testGetImdbId()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('nm0000093', $people->getImdbId());
    }

    /**
     * @test
     */
    public function testGetImdbIdFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('', $people->getImdbId());
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('Brad Pitt', $people->getName());
    }

    /**
     * @test
     */
    public function testGetNameFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getName());
    }

    /**
     * @test
     */
    public function testGetPlaceOfBirth()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('Shawnee - Oklahoma - USA', $people->getPlaceOfBirth());
    }

    /**
     * @test
     */
    public function testGetPlaceOfBirthFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getPlaceOfBirth());
    }

    /**
     * @test
     */
    public function testGetPopularity()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(1.35777, $people->getPopularity());
    }

    /**
     * @test
     */
    public function testGetPopularityFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals(0, $people->getPopularity());
    }

    /**
     * @test
     */
    public function testGetProfilePath()
    {
        $this->setRequestOk();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEquals('/lZngQUfDpPwlBRebtFo8XFuk9T3.jpg', $people->getProfilePath());
    }

    /**
     * @test
     */
    public function testGetProfilePathFailed()
    {
        $this->setRequestPeopleEmpty();

        $people = new People($this->tmdb, $this->people_id);
        $this->assertEmpty($people->getProfilePath());
    }

    public function testGetProfiles()
    {
        $people = new People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/imagesOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $profiles = $people->getProfiles();

        $this->assertInstanceOf(\Generator::class, $profiles);

        foreach ($profiles as $p)
        {
            $this->assertInstanceOf(\vfalies\tmdb\Results\Image::class, $p);
        }
    }

    public function testGetMoviesCast()
    {
        $people = new People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleMovieCreditOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $moviecast = $people->getMoviesCast();

        $this->assertInstanceOf(\Generator::class, $moviecast);

        foreach ($moviecast as $mc)
        {
            $this->assertInstanceOf(\vfalies\tmdb\Results\PeopleMovieCast::class, $mc);
        }
    }

    public function testGetMoviesCrew()
    {
        $people = new People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleMovieCreditOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $moviecrew = $people->getMoviesCrew();

        $this->assertInstanceOf(\Generator::class, $moviecrew);

        foreach ($moviecrew as $mc)
        {
            $this->assertInstanceOf(\vfalies\tmdb\Results\PeopleMovieCrew::class, $mc);
        }
    }

    public function testGetTVShowCast()
    {
        $people = new People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleTVShowCreditOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $tvshowcast = $people->getTVShowCast();

        $this->assertInstanceOf(\Generator::class, $tvshowcast);

        foreach ($tvshowcast as $tvc)
        {
            $this->assertInstanceOf(\vfalies\tmdb\Results\PeopleTVShowCast::class, $tvc);
        }
    }

    public function testGetTVShowCrew()
    {
        $people = new People($this->tmdb, $this->people_id);

        $json_object = json_decode(file_get_contents('tests/json/PeopleTVShowCreditOk.json'));
        $this->tmdb->method('getRequest')->willReturn($json_object);

        $tvshowcrew = $people->getTVShowCrew();

        $this->assertInstanceOf(\Generator::class, $tvshowcrew);

        foreach ($tvshowcrew as $tvc)
        {
            $this->assertInstanceOf(\vfalies\tmdb\Results\PeopleTVShowCrew::class, $tvc);
        }
    }
}
