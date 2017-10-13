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

use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Results;
use VfacTmdb\Abstracts\Account;
use VfacTmdb\Traits\ListItems;

/**
 * Class to manipulate account favorite
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Favorite extends Account
{
    use ListItems;

    /**
     * Get account favorite movies
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        return $this->getAccountItems('movies', Results\Movie::class);
    }

    /**
     * Get account favorite tvshows
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        return $this->getAccountItems('tv', Results\TVShow::class);
    }

    /**
     * Mark / unmark favorite items
     * @param  string $media_type type of media (movie / tv)
     * @param  int    $media_id   media id
     * @param  bool   $favorite
     * @return Favorite
     */
    private function markAsFavorite(string  $media_type, int $media_id, bool $favorite) : Favorite
    {
        try {
            $params               = [];
            $params['media_type'] = $media_type;
            $params['media_id']   = $media_id;
            $params['favorite']   = $favorite;

            $this->tmdb->postRequest('account/'.$this->account_id.'/favorite', $this->options, $params);

            return $this;
        } catch (TmdbException $e) {
            throw $e;
        }
    }

    /**
     * Marl a movie as favorite
     * @param  int    $movie_id Movie id
     * @return Favorite
     */
    public function markMovieAsFavorite(int $movie_id) : Favorite
    {
        return $this->markAsFavorite('movie', $movie_id, true);
    }
    /**

     * Unmark a movie as favorite
     * @param int $movie_id Movie id
     * @return Favorite
     */
    public function unmarkMovieAsFavorite(int $movie_id) : Favorite
    {
        return $this->markAsFavorite('movie', $movie_id, false);
    }

    /**
     * Mark a TV show as favorkite
     * @param  int $tvshow_id TV show id
     * @return Favorite
     */
    public function markTVShowAsFavorite(int $tvshow_id) : Favorite
    {
        return $this->markAsFavorite('tv', $tvshow_id, true);
    }

    /**
     * Unmark a TV show as favorite
     * @param  int $tvshow_id TV Show id
     * @return Favorite
     */
    public function unmarkTVShowAsFavorite(int $tvshow_id) : Favorite
    {
        return $this->markAsFavorite('tv', $tvshow_id, false);
    }

    /**
     * Get account favorite items
     * @param  string $item         item name, possible value : movies / tv
     * @param  string $result_class class for the results
     * @return \Generator
     */
    private function getAccountItems(string $item, string $result_class) : \Generator
    {
        $response = $this->tmdb->getRequest('account/'.$this->account_id.'/favorite/'.$item, $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, $result_class);
    }
}
