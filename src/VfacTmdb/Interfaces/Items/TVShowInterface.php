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


namespace VfacTmdb\Interfaces\Items;

/**
 * Interface for TVShow type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TVShowInterface
{

    /**
     * Get TV show id
     * @return int
     */
    public function getId() : int;

    /**
     * Get TVShow genres
     * @return array
     */
    public function getGenres() : array;

    /**
     * Get TVShow title
     * @return string
     */
    public function getTitle() : string;

    /**
     * Get TVShow overview
     * @return string
     */
    public function getOverview() : string;

    /**
     * Get TVShow release date
     * @return string
     */
    public function getReleaseDate() : string;

    /**
     * Get TVShow original title
     * @return string
     */
    public function getOriginalTitle() : string;

    /**
     * Get TVShow note
     * @return float
     */
    public function getNote() : float;

    /**
     * Get TVShow number of episodes
     * @return int
     */
    public function getNumberEpisodes() : int;

    /**
     * Get TVShow number of seasons
     * @return int
     */
    public function getNumberSeasons() : int;

    /**
     * Get TVShow status
     * @return string
     */
    public function getStatus() : string;

    /**
     * Get TVShow seasons
     * @return \Generator
     */
    public function getSeasons() : \Generator;

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath() : string;

    /**
     * Get backdrop path
     * @return string
     */
    public function getBackdropPath() : string;
}
