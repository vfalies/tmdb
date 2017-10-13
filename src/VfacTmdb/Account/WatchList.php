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


namespace VfacTmdb\Account;

use VfacTmdb\Results;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Traits\ListItems;
use VfacTmdb\Abstracts\Account;

/**
 * Class to manipulate account watchlist
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class WatchList extends Account
{
    use ListItems;

    /**
     * Get movies watchlist
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        $response = $this->tmdb->getRequest('account/'.$this->account_id.'/watchlist/movies', $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, Results\Movie::class);
    }

    /**
     * Get TV shows watchlist
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        $response = $this->tmdb->getRequest('account/'.$this->account_id.'/watchlist/tv', $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, Results\TVShow::class);
    }

    /**
     * Add / remove in watchlist items
     * @param  string    $media_type Media type (movie / tv)
     * @param  int       $media_id    item id
     * @param  bool      $watchlist
     * @return WatchList
     */
    private function setWatchlistItem(string $media_type, int $media_id, bool $watchlist) : WatchList
    {
        try {
            $params               = [];
            $params['media_type'] = $media_type;
            $params['media_id']   = $media_id;
            $params['watchlist']  = $watchlist;

            $this->tmdb->postRequest('account/'.$this->account_id.'/watchlist', $this->options, $params);

            return $this;
        } catch (TmdbException $e) {
            throw $e;
        }
    }

    /**
     * Add movie in watchlist
     * @param  int       $movie_id movie id
     * @return WatchList
     */
    public function addMovie(int $movie_id) : WatchList
    {
        return $this->setWatchlistItem('movie', $movie_id, true);
    }

    /**
     * Remove movie from watchlist
     * @param  int       $movie_id movie id
     * @return WatchList
     */
    public function removeMovie(int $movie_id) : WatchList
    {
        return $this->setWatchlistItem('movie', $movie_id, false);
    }

    /**
     * Add TV show in watchlist
     * @param  int    $tvshow_id TV show id
     * @return WatchList
     */
    public function addTVShow(int $tvshow_id) : WatchList
    {
        return $this->setWatchlistItem('tv', $tvshow_id, true);
    }

    /**
     * Remove TV show from watchlist
     * @param  int    $tvshow_id TV show id
     * @return WatchList
     */
    public function removeTVShow(int $tvshow_id) : WatchList
    {
        return $this->setWatchlistItem('tv', $tvshow_id, false);
    }
}
