<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\TVEpisodeResultsInterface;

class TVEpisode extends Results implements TVEpisodeResultsInterface
{

    protected $episode_number = 0;
    protected $name           = '';

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id              = $this->data->id;
        $this->release_date    = $this->data->air_date;
        $this->season_number   = $this->data->season_number;
        $this->episode_number  = $this->data->episode_number;
        $this->name            = $this->data->name;
        $this->vote_average    = $this->data->vote_average;
        $this->vote_count      = $this->data->vote_count;
        $this->overview        = $this->data->overview;
        $this->production_code = $this->data->production_code;
        $this->still_path      = $this->data->still_path;
    }

    public function getAirDate(): string
    {
        return $this->release_date;
    }

    public function getCrew(): \Generator
    {
        throw new \Exception('Not yep implemented');
    }

    public function getEpisodeNumber(): int
    {
        return (int) $this->episode_number;
    }

    public function getGuestStars(): \Generator
    {
        throw new \Exception('Not yep implemented');
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNote(): float
    {
        return $this->vote_average;
    }

    public function getNoteCount(): int
    {
        return (int) $this->vote_count;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getProductionCode(): string
    {
        return $this->production_code;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function getSeasonNumber(): int
    {
        return (int) $this->season_number;
    }

    public function getStillPath(): string
    {
        return $this->still_path;
    }

}
