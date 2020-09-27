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
 * Interface for Movie type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface MovieInterface
{

    /**
     * Get movie genres
     * @return array
     */
    public function getGenres() : array;
    /**
     * Get movie title
     * @return string
     */
    public function getTitle() : string;

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview() : string;

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate() : string;

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle() : string;

    /**
     * Get movie note
     * @return float
     */
    public function getNote() : float;

    /**
     * Get movie id
     * @return int
     */
    public function getId() : int;

    /**
     * Get IMDB movie id
     * @return string
     */
    public function getIMDBId() : string;

    /**
     * Get movie tagline
     * @return string
     */
    public function getTagLine() : string;

    /**
     * Get collection id
     * @return int
     */
    public function getCollectionId() : int;

    /**
     * Get poster path
     */
    public function getPosterPath() : string;

    /**
     * Get backdrop path
     */
    public function getBackdropPath() : string;
}
