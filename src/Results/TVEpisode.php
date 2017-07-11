<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\TVEpisodeResultsInterface;
use vfalies\tmdb\Exceptions\NotYetImplementedException;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Results\Crew;

class TVEpisode extends Results implements TVEpisodeResultsInterface
{

    use ElementTrait;

    protected $episode_number  = 0;
    protected $name            = '';
    protected $air_date        = null;
    protected $season_number   = 0;
    protected $vote_average    = 0;
    protected $vote_count      = 0;
    protected $overview        = '';
    protected $production_code = '';
    protected $still_path      = '';
    protected $id              = null;

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
        $this->air_date        = $this->data->air_date;
        $this->season_number   = $this->data->season_number;
        $this->episode_number  = $this->data->episode_number;
        $this->name            = $this->data->name;
        $this->vote_average    = $this->data->vote_average;
        $this->vote_count      = $this->data->vote_count;
        $this->overview        = $this->data->overview;
        $this->production_code = $this->data->production_code;
        $this->still_path      = $this->data->still_path;
    }

    public function getAirDate()
    {
        return $this->air_date;
    }

    public function getCrew()
    {
        if ( ! empty($this->data->crew))
        {
            foreach ($this->data->crew as $crew)
            {
                $crew->gender = null;

                $return = new Crew($this->tmdb, $crew);
                yield $return;
            }
        }
    }

    public function getEpisodeNumber()
    {
        return (int) $this->episode_number;
    }

    /**
     * @codeCoverageIgnore
     * @throws NotYetImplementedException
     */
    public function getGuestStars()
    {
        throw new NotYetImplementedException;
    }

    public function getId()
    {
        return (int) $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNote()
    {
        return $this->vote_average;
    }

    public function getNoteCount()
    {
        return (int) $this->vote_count;
    }

    public function getOverview()
    {
        return $this->overview;
    }

    public function getProductionCode()
    {
        return $this->production_code;
    }

    public function getSeasonNumber()
    {
        return (int) $this->season_number;
    }

    public function getStillPath()
    {
        return $this->still_path;
    }

}
