<?php

namespace Vfac\Tmdb;

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{

    /**
     * @covers Vfac\Tmdb\Search::searchMovie
     * @test
     */
    public function testSearchMovie()
    {
        $this->assertTrue(true);

        $tmdb   = new Tmdb('62dfe9839b8937e595e325a4144702ad');
        $search = new Search($tmdb);
        $responses = $search->searchMovie('star wars');

        $this->assertInstanceOf('Generator', $responses);
    }

}
