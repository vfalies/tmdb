<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
* @package Tmdb 
* @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Interfaces\Items;

interface MovieInterface
{

    /**
     * Get movie genres
     * @return array
     */
    public function getGenres();
    /**
     * Get movie title
     * @return string
     */
    public function getTitle();

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview();

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate();

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle();

    /**
     * Get movie note
     * @return float
     */
    public function getNote();

    /**
     * Get movie id
     * @return int
     */
    public function getId();

    /**
     * Get IMDB movie id
     * @return int
     */
    public function getIMDBId();

    /**
     * Get movie tagline
     * @return string
     */
    public function getTagLine();

    /**
     * Get collection id
     * @return int
     */
    public function getCollectionId();

    /**
     * Get poster path
     */
    public function getPosterPath();

    /**
     * Get backdrop path
     */
    public function getBackdropPath();
}
