<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\TVSeasonResultsInterface;

class TVSeason extends Results implements TVSeasonResultsInterface
{

    protected $episode_count = 0;
    protected $season_number = 0;
    protected $poster_path   = null;
    protected $air_date  = null;

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
        $this->id            = $this->data->id;
        $this->air_date  = $this->data->air_date;
        $this->episode_count = $this->data->episode_count;
        $this->poster_path   = $this->data->poster_path;
        $this->season_number = $this->data->season_number;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAirDate()
    {
        return $this->air_date;
    }

    public function getEpisodeCount()
    {
        return (int) $this->episode_count;
    }

    public function getSeasonNumber()
    {
        return (int) $this->season_number;
    }
}
