<?php

namespace Vfac\Tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Search
 */
class SearchTest extends TestCase
{

    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
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
    public function testSearchMovieValid()
    {
        $json_object = json_decode(file_get_contents('tests/searchMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->searchMovie('star wars', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->current());

        return $search;
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testSearchMovieInvalidOption()
    {
        $search = new Search($this->tmdb);

        $search->searchMovie('star wars', array('fake_option' => 'test'));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testSearchMovieEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $search->searchMovie('');
    }

    /**
     * @test
     */
    public function testSearchTVShowValid()
    {
        $json_object = json_decode(file_get_contents('tests/searchTVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->searchTVShow('star trek', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\TVShow::class, $responses->current());

        return $search;
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testSearchTVShowInvalidOption()
    {
        $search = new Search($this->tmdb);

        $search->searchTVShow('star trek', array('fake_option' => 'test'));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testSearchTVShowEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $search->searchTVShow('');
    }

    /**
     * @test
     */
    public function testSearchCollectionValid()
    {
        $json_object = json_decode(file_get_contents('tests/searchCollectionOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $search    = new Search($this->tmdb);
        $responses = $search->searchCollection('star wars', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Collection::class, $responses->current());

        return $search;
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testSearchCollectionInvalidOption()
    {
        $search = new Search($this->tmdb);

        $search->searchCollection('star wars', array('fake_option' => 'test'));
    }

    /**
     * @expectedException \Exception
     * @test
     */
    public function testSearchCollectionEmptyQuery()
    {
        $search = new Search($this->tmdb);

        $search->searchCollection('');
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

}
