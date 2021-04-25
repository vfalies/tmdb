<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class CompanyTest extends TestCase
{
    protected $tmdb     = null;
    protected $company    = null;
    protected $company_id = 1;

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

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/companyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestCompanyEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/companyEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/companyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testContructFailure()
    {
        $this->expectException(\Exception::class);
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new Company($this->tmdb, $this->company_id);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('Lucasfilm', $company->getName());
    }

    /**
     * @test
     */
    public function testGetNameFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getName());
    }

    /**
     * @test
     */
    public function testGetDescription()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('A Georges Lucas company', $company->getDescription());
    }

    /**
     * @test
     */
    public function testGetDescriptionFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getDescription());
    }

    /**
     * @test
     */
    public function testGetHeadquarters()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('San Francisco, California', $company->getHeadQuarters());
    }

    /**
     * @test
     */
    public function testGetHeadQuartersFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getHeadQuarters());
    }

    /**
     * @test
     */
    public function testGetHomepage()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('http://www.lucasfilm.com', $company->getHomePage());
    }

    /**
     * @test
     */
    public function testGetHomepageFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getHomePage());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('/3/company/'.$this->company_id, parse_url($this->tmdb->url, PHP_URL_PATH));
        $this->assertEquals($this->company_id, $company->getId());
    }

    /**
     * @test
     */
    public function testGetIdFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals(0, $company->getId());
    }

    /**
      * @test
      */
    public function testGetLogoPath()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);
        $this->assertIsString($company->getLogoPath());
        $this->assertNotEmpty($company->getLogoPath());
    }

    /**
     * @test
     */
    public function testGetLogoPathFailure()
    {
        $this->setRequestCompanyEmpty();
        $company = new Company($this->tmdb, $this->company_id);
        $this->assertIsString($company->getLogoPath());
        $this->assertEmpty($company->getLogoPath());
    }

    public function testGetMovies()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/companyMoviesOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $company = new Company($this->tmdb, $this->company_id);
        $movies = $company->getMovies();

        $this->assertInstanceOf(\Generator::class, $movies);
        foreach ($movies as $m) {
            $this->assertEquals('/3/company/'.$this->company_id.'/movies', parse_url($this->tmdb->url, PHP_URL_PATH));
            $this->assertInstanceOf(\VfacTmdb\Results\Movie::class, $m);
        }
    }
}
