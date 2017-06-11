<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVEpisodeInterface;
use vfalies\tmdb\Tmdb;

class TVEpisode extends Item implements TVEpisodeInterface
{

    public function __construct(Tmdb $tmdb, int $tv_id, int $season_number, int $episode_number, array $options = array())
    {
        parent::__construct($tmdb, $episode_number, $options, 'tv/' . $tv_id . '/' . $season_number);
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId(): int
    {
        if (isset($this->data->id))
        {
            return (int) $this->data->id;
        }
        return 0;
    }

    public function getAirDate(): string
    {
        if (isset($this->data->air_date))
        {
            return $this->data->air_date;
        }
        return '';
    }

    public function getCrew(): \Generator
    {
        throw new Exception('Not yet implemented');
    }

    public function getEpisodeNumber(): int
    {
        if (isset($this->data->episode_number))
        {
            return $this->data->episode_number;
        }
        return 0;
    }

    public function getGuestStars(): \Generator
    {
        throw new Exception('Not yet implemented');
    }

    public function getName(): string
    {        
        if (isset($this->data->name))
        {
            return $this->data->name;
        }
        return '';
    }

    public function getNote(): float
    {
        if (isset($this->data->vote_average))
        {
            return $this->data->vote_average;
        }
        return 0;
    }

    public function getNoteCount(): int
    {
        if (isset($this->data->vote_count))
        {
            return (int) $this->data->vote_count;
        }
        return 0;
    }

    public function getOverview(): string
    {
        if (isset($this->data->overview))
        {
            return $this->data->overview;
        }
        return '';
    }

    public function getProductionCode(): string
    {
        if (isset($this->data->production_code))
        {
            return $this->data->production_code;
        }
        return '';
    }

    public function getSeasonNumber(): int
    {
        if (isset($this->data->season_number))
        {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    public function getStillPath(): string
    {
        if (isset($this->data->still_path))
        {
            return $this->data->still_path;
        }
        return '';
    }

}
