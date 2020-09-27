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
 * Class to manipulate account favorite
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Favorite extends Account
{

    /**
     * Get account favorite movies
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        return $this->getAccountListItems('favorite', 'movies', Results\Movie::class);
    }

    /**
     * Get account favorite tvshows
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        return $this->getAccountListItems('favorite', 'tv', Results\TVShow::class);
    }

    /**
     * Marl a movie as favorite
     * @param  int    $movie_id Movie id
     * @return Favorite
     */
    public function markMovieAsFavorite(int $movie_id) : Favorite
    {
        return $this->setListItem('favorite', 'movie', $movie_id, true);
    }
    /**
     * Unmark a movie as favorite
     * @param int $movie_id Movie id
     * @return Favorite
     */
    public function unmarkMovieAsFavorite(int $movie_id) : Favorite
    {
        return $this->setListItem('favorite', 'movie', $movie_id, false);
    }

    /**
     * Mark a TV show as favorkite
     * @param  int $tvshow_id TV show id
     * @return Favorite
     */
    public function markTVShowAsFavorite(int $tvshow_id) : Favorite
    {
        return $this->setListItem('favorite', 'tv', $tvshow_id, true);
    }

    /**
     * Unmark a TV show as favorite
     * @param  int $tvshow_id TV Show id
     * @return Favorite
     */
    public function unmarkTVShowAsFavorite(int $tvshow_id) : Favorite
    {
        return $this->setListItem('favorite', 'tv', $tvshow_id, false);
    }
}
