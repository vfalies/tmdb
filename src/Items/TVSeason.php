<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVSeasonInterface;
use vfalies\tmdb\Tmdb;

class TVSeason extends Item implements TVSeasonInterface
{

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $tv_id
     * @param int $season_number
     * @param array $options
     * @throws Exception
     */
    public function __construct(Tmdb $tmdb, int $tv_id, int $season_number, array $options = array())
    {
        parent::__construct($tmdb, $season_number, $options, 'tv/' . $tv_id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAirDate(): string
    {
        if (!empty($this->data->air_date))
        {
            return (int) $this->data->air_date;
        }
        return '';
    }

    public function getEpisodeCount(): int
    {

    }

    public function getSeasonNumber(): int
    {
        if (!empty($this->data->season_number))
        {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    public function getEpisodes(): \Generator
    {

    }

    public function getName(): string
    {
        if (!empty($this->data->name))
        {
            return (int) $this->data->name;
        }
        return '';
    }

    public function getOverview(): string
    {
        if (!empty($this->data->overview))
        {
            return (int) $this->data->overview;
        }
        return '';
    }

}
