<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class SearchTest extends TestCase
{
    protected $tmdb = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
                ->getMock();
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testSearchMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->movie('star wars', array('language' => 'fr-FR'));

        $this->assertEquals('/3/search/movie', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->current());

        return $search;
    }

    /**
     * @test
     */
    public function testSearchMovieEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchMovieEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->movie('search_with_no_result', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertNull($responses->current());
    }

    /**
     * @test
     */
    public function testSearchMovieEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $search->movie('');
    }

    /**
     * @test
     */
    public function testSearchTVShowValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchTVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->tvshow('star trek', array('language' => 'fr-FR'));

        $this->assertEquals('/3/search/tv', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\TVShow::class, $responses->current());

        return $search;
    }

    /**
     * @test
     */
    public function testSearchTVShowEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $search->tvshow('');
    }

    /**
     * @test
     */
    public function testSearchCollectionValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchCollectionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->collection('star wars', array('language' => 'fr-FR'));

        $this->assertEquals('/3/search/collection', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Collection::class, $responses->current());

        return $search;
    }

    /**
     * @test
     */
    public function testSearchCollectionEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $search->collection('');
    }

    /**
     * @test
     * @depends testSearchMovieValid
     */
    public function testGetPage($search)
    {
        $this->assertEquals(1, $search->getPage());
    }

    /**
     * @test
     * @depends testSearchMovieValid
     */
    public function testTotalPages($search)
    {
        $this->assertEquals(6, $search->getTotalPages());
    }

    /**
     * @test
     * @depends testSearchMovieValid
     */
    public function testTotalResults($search)
    {
        $this->assertEquals(106, $search->getTotalResults());
    }

    /**
     * @test
     */
    public function testSearchPeopleValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchPeopleOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->people('Bradley Cooper', array('language' => 'fr-FR'));

        $this->assertEquals('/3/search/person', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\People::class, $responses->current());

        return $search;
    }

    /**
     * @test
     */
    public function testSearchPeopleEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchPeopleEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->people('search_with_no_result', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertNull($responses->current());
    }

    /**
     * @test
     */
    public function testSearchPeopleEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $search->people('');
    }
    /**
     * @test
     */
    public function testSearchCompanyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchCompanyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->company('lucasfilm', array('language' => 'fr-FR'));

        $this->assertEquals('/3/search/company', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Company::class, $responses->current());

        return $search;
    }

    /**
     * @test
     */
    public function testSearchCompanyEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/searchCompanyEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->company('search_with_no_result', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertNull($responses->current());
    }

    /**
     * @test
     */
    public function testSearchCompanyEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $search->company('');
    }
}
