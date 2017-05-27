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

        $json = file_get_contents('tests/searchMovieOk.json');

        $json_object = json_decode($json);
        $this->tmdb  = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();
        $this->tmdb->method('sendRequest')->willReturn($json_object);
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
        $search    = new Search($this->tmdb);
        $responses = $search->searchMovie('star wars', array('language' => 'fr-FR'));

        $this->assertInstanceOf(\Generator::class, $responses);
        $this->assertInstanceOf(Results\Movie::class, $responses->current());
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

}
