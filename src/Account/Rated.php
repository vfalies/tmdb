<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Account;

use vfalies\tmdb\Results;
use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Interfaces\AuthInterface;
use vfalies\tmdb\Traits\ListItems;
use vfalies\tmdb\Abstracts;

/**
 * Class to manipulate account rated
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Rated extends Abstracts\Account
{
    use ListItems;

    /**
     * Get movies rated
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        $response = $this->tmdb->getRequest('/account/'.$this->account_id.'/rated/movies', null, $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, Results\Movie::class);
    }

    /**
     * Get TV shows rated
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        $response = $this->tmdb->getRequest('/account/'.$this->account_id.'/rated/tv', null, $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, Results\TVShow::class);
    }

    /**
     * Get TV episodes rated
     * @return \Generator|Results\TVEpisode
     */
    public function getTVEpisodes() : \Generator
    {
        $response = $this->tmdb->getRequest('/account/'.$this->account_id.'/rated/tv/episodes', null, $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, Results\TVEpisode::class);
    }
}
