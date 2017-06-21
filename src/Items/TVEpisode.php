<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVEpisodeInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotYetImplementedException;

class TVEpisode extends Item implements TVEpisodeInterface
{

    public function __construct(Tmdb $tmdb, $tv_id, $season_number, $episode_number, array $options = array())
    {
        parent::__construct($tmdb, $episode_number, $options, 'tv/' . $tv_id . '/' . $season_number);
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId()
    {
        if (isset($this->data->id)) {
            return (int) $this->data->id;
        }
        return 0;
    }

    public function getAirDate()
    {
        if (isset($this->data->air_date)) {
            return $this->data->air_date;
        }
        return '';
    }

    /**
     * @codeCoverageIgnore
     * @throws NotYetImplementedException
     */
    public function getCrew()
    {
        throw new NotYetImplementedException;
    }

    public function getEpisodeNumber()
    {
        if (isset($this->data->episode_number)) {
            return $this->data->episode_number;
        }
        return 0;
    }

    /**
     * @codeCoverageIgnore
     * @throws NotYetImplementedException
     */
    public function getGuestStars()
    {
        throw new NotYetImplementedException;
    }

    public function getName()
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    public function getNote()
    {
        if (isset($this->data->vote_average)) {
            return $this->data->vote_average;
        }
        return 0;
    }

    public function getNoteCount()
    {
        if (isset($this->data->vote_count)) {
            return (int) $this->data->vote_count;
        }
        return 0;
    }

    public function getOverview()
    {
        if (isset($this->data->overview)) {
            return $this->data->overview;
        }
        return '';
    }

    public function getProductionCode()
    {
        if (isset($this->data->production_code)) {
            return $this->data->production_code;
        }
        return '';
    }

    public function getSeasonNumber()
    {
        if (isset($this->data->season_number)) {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    public function getStillPath()
    {
        if (isset($this->data->still_path)) {
            return $this->data->still_path;
        }
        return '';
    }
}
