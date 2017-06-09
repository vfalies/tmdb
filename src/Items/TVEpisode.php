<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVEpisodeInterface;
use vfalies\tmdb\Tmdb;

class TVEpisode extends Item implements TVEpisodeInterface
{

    public function __construct(Tmdb $tmdb, int $tv_id, int $season_number, int $episode_number, array $options = array())
    {
        parent::__construct($tmdb, $episode_number, $options, 'tv/'.$tv_id.'/'.$season_number);
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getAirDate(): string
    {

    }

    public function getCrew(): \Generator
    {

    }

    public function getEpisodeNumber(): int
    {

    }

    public function getGuestStars(): \Generator
    {

    }

    public function getName(): string
    {

    }

    public function getNote(): float
    {

    }

    public function getNoteCount(): float
    {

    }

    public function getOverview(): string
    {

    }

    public function getProductionCode(): string
    {

    }

    public function getSeasonNumber(): int
    {

    }

    public function getStillPath(): string
    {

    }

}
