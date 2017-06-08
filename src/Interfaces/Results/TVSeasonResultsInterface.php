<?php

namespace vfalies\tmdb\Interfaces\Results;

interface TVSeasonResultsInterface extends ResultsInterface
{

    public function getEpisodeCount(): int;

    public function getPosterPath(): string;

    public function getSeasonNumber(): int;
}
