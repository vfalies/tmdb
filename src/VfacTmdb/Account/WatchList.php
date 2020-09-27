<?php declare(strict_types=1);
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
use VfacTmdb\Abstracts\Account;

/**
 * Class to manipulate account watchlist
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class WatchList extends Account
{

    /**
     * Get movies watchlist
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        return $this->getAccountListItems('watchlist', 'movies', Results\Movie::class);
    }

    /**
     * Get TV shows watchlist
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        return $this->getAccountListItems('watchlist', 'tv', Results\TVShow::class);
    }

    /**
     * Add movie in watchlist
     * @param  int       $movie_id movie id
     * @return WatchList
     */
    public function addMovie(int $movie_id) : WatchList
    {
        return $this->setListItem('watchlist', 'movie', $movie_id, true);
    }

    /**
     * Remove movie from watchlist
     * @param  int       $movie_id movie id
     * @return WatchList
     */
    public function removeMovie(int $movie_id) : WatchList
    {
        return $this->setListItem('watchlist', 'movie', $movie_id, false);
    }

    /**
     * Add TV show in watchlist
     * @param  int    $tvshow_id TV show id
     * @return WatchList
     */
    public function addTVShow(int $tvshow_id) : WatchList
    {
        return $this->setListItem('watchlist', 'tv', $tvshow_id, true);
    }

    /**
     * Remove TV show from watchlist
     * @param  int    $tvshow_id TV show id
     * @return WatchList
     */
    public function removeTVShow(int $tvshow_id) : WatchList
    {
        return $this->setListItem('watchlist', 'tv', $tvshow_id, false);
    }
}
