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
use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\Traits\ListItems;
use vfalies\tmdb\Abstracts;

/**
 * Class to manipulate account watchlist
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class WatchList extends Abstracts\Account
{
    use ListItems;

    /**
     * Get movies watchlist
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
      $response = $this->tmdb->getRequest('/account/'.$this->account_id.'/watchlist/movies', null, $this->options);

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
      $response = $this->tmdb->getRequest('/account/'.$this->account_id.'/watchlist/tv', null, $this->options);

      $this->page          = (int) $response->page;
      $this->total_pages   = (int) $response->total_pages;
      $this->total_results = (int) $response->total_results;

      return $this->searchItemGenerator($response->results, Results\TVShow::class);
    }

    /**
     * Add / remove in watchlist items
     * @param  string    $media_type Media type (movie / tv)
     * @param  int       $item_id    item id
     * @param  bool      $watchlist
     * @return WatchList
     */
    private function setWatchlistItem(string $media_type, int $item_id, bool $watchlist) : WatchList
    {
      try {
          $params               = [];
          $params['media_type'] = $media_type;
          $params['media_id']   = $media_id;
          $params['favorite']   = $favorite;

          $this->tmdb->postRequest('/account/'.$this->account_id.'/watchlist', null, $this->options);

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
     * @param  [type]    $tvshow_id TV show id
     * @return WatchList
     */
    public function addTVShow($tvshow_id) : WatchList
    {
        return $this->setWatchlistItem('tv', $tvshow_id, true);
    }

    /**
     * Remove TV show from watchlist
     * @param  [type]    $tvshow_id TV show id
     * @return WatchList
     */
    public function removeTVShow($tvshow_id) : WatchList
    {
        return $this->setWatchlistItem('tv', $tvshow_id, false);
    }
}
