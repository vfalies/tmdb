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
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Abstracts\Account;

/**
 * Class to manipulate account rated
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Rated extends Account
{

    /**
     * Get movies rated
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        return $this->getAccountListItems('rated', 'movies', Results\Movie::class);
    }

    /**
     * Get TV shows rated
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        return $this->getAccountListItems('rated', 'tv', Results\TVShow::class);
    }

    /**
     * Get TV episodes rated
     * @return \Generator|Results\TVEpisode
     */
    public function getTVEpisodes() : \Generator
    {
        return $this->getAccountListItems('rated', 'tv/episodes', Results\TVEpisode::class);
    }

    /**
     * Add movie rate
     * @param  int   $movie_id
     * @param  float $rate
     * @return Rated
     */
    public function addMovieRate(int $movie_id, float $rate) : Rated
    {
        return $this->addRate('movie/' . $movie_id . '/rating', $rate);
    }

    /**
     * Remove movie rate
     * @param  int   $movie_id
     * @return Rated
     */
    public function removeMovieRate(int $movie_id) : Rated
    {
        return $this->removeRate('movie/' . $movie_id . '/rating');
    }

    /**
     * Add TVShow rate
     * @param  int   $tv_id
     * @param  float $rate
     * @return Rated
     */
    public function addTVShowRate(int $tv_id, float $rate) : Rated
    {
        return $this->addRate('tv/' . $tv_id . '/rating', $rate);
    }

    /**
     * Remove TVShow rate
     * @param  int   $tv_id
     * @return Rated
     */
    public function removeTVShowRate(int $tv_id) : Rated
    {
        return $this->removeRate('tv/' . $tv_id . '/rating');
    }

    /**
     * Add TVShow episode rate
     * @param  int   $tv_id
     * @param  int   $season_number
     * @param  int   $episode_number
     * @param  float $rate
     * @return Rated
     */
    public function addTVShowEpisodeRate(int $tv_id, int $season_number, int $episode_number, float $rate) : Rated
    {
        return $this->addRate('tv/' . $tv_id . '/season/' . $season_number . '/episode/' . $episode_number . '/rating', $rate);
    }

    /**
     * Remove TVSHow episode rate
     * @param  int   $tv_id
     * @param  int   $season_number
     * @param  int   $episode_number
     * @return Rated
     */
    public function removeTVShowEpisodeRate(int $tv_id, int $season_number, int $episode_number) : Rated
    {
        return $this->removeRate('tv/' . $tv_id . '/season/' . $season_number . '/episode/' . $episode_number . '/rating');
    }

    /**
     * Add rate
     * @param  string $action uri action
     * @param  float  $rate
     * @return Rated
     */
    private function addRate(string $action, float $rate) : Rated
    {
        try {
            $params = [];
            $params['value'] = $rate;

            $this->tmdb->postRequest($action, $this->options, $params);

            return $this;
        } catch (TmdbException $e) {
            throw $e;
        }
    }

    /**
     * Remove Rate
     * @param  string $action uri action
     * @return Rated
     */
    private function removeRate(string $action) : Rated
    {
        try {
            $this->tmdb->deleteRequest($action, $this->options);

            return $this;
        } catch (TmdbException $e) {
            throw $e;
        }
    }
}
