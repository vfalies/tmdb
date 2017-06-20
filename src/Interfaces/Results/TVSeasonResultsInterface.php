<?php

namespace vfalies\tmdb\Interfaces\Results;

interface TVSeasonResultsInterface extends ResultsInterface
{

    public function getEpisodeCount(): int;

    public function getPosterPath(): string;

    public function getSeasonNumber(): int;

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate();
}
