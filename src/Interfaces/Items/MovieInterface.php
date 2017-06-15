<?php

namespace vfalies\tmdb\Interfaces\Items;

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
     * @return int
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
    public function getPosterPath(): string;

    /**
     * Get backdrop path
     */
    public function getBackdropPath(): string;

}
