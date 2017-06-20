<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVShowInterface;
use vfalies\tmdb\Tmdb;

class TVShow extends Item implements TVShowInterface
{

    public function __construct(Tmdb $tmdb, int $tv_id, array $options = array())
    {
        parent::__construct($tmdb, $tv_id, $options, 'tv');
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get TVSHow genres
     * @return array
     */
    public function getGenres(): array
    {
        if (isset($this->data->genres)) {
            return $this->data->genres;
        }
        return [];
    }

    /**
     * Get TVshow note
     *  @return float
     */
    public function getNote(): float
    {
        if (isset($this->data->vote_average)) {
            return $this->data->vote_average;
        }
        return 0;
    }

    /**
     * Get TVshow number of episodes
     * @return int
     */
    public function getNumberEpisodes(): int
    {
        if (isset($this->data->number_of_episodes)) {
            return $this->data->number_of_episodes;
        }
        return 0;
    }

    /**
     * Get TVShow number of seasons
     * @return int
     */
    public function getNumberSeasons(): int
    {
        if (isset($this->data->number_of_seasons)) {
            return $this->data->number_of_seasons;
        }
        return 0;
    }

    /**
     * Get TVShow original title
     * @return string
     */
    public function getOriginalTitle(): string
    {
        if (isset($this->data->original_name)) {
            return $this->data->original_name;
        }
        return '';
    }

    /**
     * Get TVShow overview
     * @return string
     */
    public function getOverview(): string
    {
        if (isset($this->data->overview)) {
            return $this->data->overview;
        }
        return '';
    }

    /**
     * Get TVShow release date
     * @return string
     */
    public function getReleaseDate(): string
    {
        if (isset($this->data->first_air_date)) {
            return $this->data->first_air_date;
        }
        return '';
    }

    /**
     * Get TVShow status
     * @return string
     */
    public function getStatus(): string
    {
        if (isset($this->data->status)) {
            return $this->data->status;
        }
        return '';
    }

    /**
     * Get TVShow title
     * @return string
     */
    public function getTitle(): string
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Get TVShow seasons
     * @return \Generator
     * @throws \Exception
     */
    public function getSeasons(): \Generator
    {
        if (!empty($this->data->seasons)) {
            foreach ($this->data->seasons as $season) {
                $season = new \vfalies\tmdb\Results\TVSeason($this->tmdb, $season);
                yield $season;
            }
        }
    }
}
