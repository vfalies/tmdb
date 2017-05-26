<?php

namespace Vfac\Tmdb\Interfaces;

interface Movie
{

    /**
     * Get all movie genres list
     * @return array
     */
    public function getAllGenres();

    /**
     * Get movie genres
     * @return array
     */
    public function getGenres();
    /**
     * Get movie title
     * @return string|null
     */
    public function getTitle();

    /**
     * Get movie overview
     * @return string|null
     */
    public function getOverview();

    /**
     * Get movie release date
     * @return string|null
     */
    public function getReleaseDate();

    /**
     * Get movie original title
     * @return string|null
     */
    public function getOriginalTitle();

    /**
     * Get movie note
     * @return number|null
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
     * Get movie poster
     * @param string $size
     * @return string
     */
    public function getPoster(string $size = 'w185');

    /**
     * Get movie backdrop
     * @param string $size
     * @return string|null
     */
    public function getBackdrop(string $size = 'w780');
}
