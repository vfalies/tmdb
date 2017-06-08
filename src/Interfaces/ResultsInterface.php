<?php

namespace vfalies\tmdb\Interfaces;

interface ResultsInterface
{

    /**
     * Get  ID
     * @return int
     */
    public function getId();

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate();

    /**
     * Get movie poster
     * @return string
     */
    public function getPoster();

}
