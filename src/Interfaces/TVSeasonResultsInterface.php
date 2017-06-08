<?php

namespace vfalies\tmdb\Interfaces;

interface TVSeasonResultsInterface extends ResultsInterface
{

    public function getEpisodeCount(): int;

    public function getPosterPath(): string;

    public function getSeasonNumber(): int;
}
