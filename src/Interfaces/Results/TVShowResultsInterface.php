<?php

namespace vfalies\tmdb\Interfaces\Results;

interface TVShowResultsInterface extends ResultsInterface
{

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview();

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle();

    /**
     * Get movie title
     * @return string
     */
    public function getTitle();


    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate();
    
}
