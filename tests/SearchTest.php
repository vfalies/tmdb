<?php

namespace Vfac\Tmdb;

class SearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Vfac\Tmdb\Search::getMovie
     */
    public function testGetMovie()
    {
        $tmdb   = new Tmdb('62dfe9839b8937e595e325a4144702ad');
        $search = new Search($tmdb);
        $responses = $search->searchMovie('star wars');

        $this->assertInstanceOf('Generator', $responses);
    }

}
