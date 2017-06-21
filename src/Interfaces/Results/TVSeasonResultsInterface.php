<?php

namespace vfalies\tmdb\Interfaces\Results;

interface TVSeasonResultsInterface extends ResultsInterface
{

    public function getEpisodeCount();

    public function getPosterPath();

    public function getSeasonNumber();

    /**
     * Get movie release date
     * @return string
     */
    public function getAirDate();
}
