<?php

namespace vfalies\tmdb\Interfaces\Items;

interface TVShowInterface
{

    /**
     * Get TV show id
     * @return int
     */
    public function getId(): int;

    /**
     * Get TVShow genres
     * @return array
     */
    public function getGenres(): array;

    /**
     * Get TVShow title
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get TVShow overview
     * @return string
     */
    public function getOverview(): string;

    /**
     * Get TVShow release date
     * @return string
     */
    public function getReleaseDate(): string;

    /**
     * Get TVShow original title
     * @return string
     */
    public function getOriginalTitle(): string;

    /**
     * Get TVShow note
     * @return float
     */
    public function getNote(): float;

    /**
     * Get TVShow number of episodes
     * @return int
     */
    public function getNumberEpisodes(): int;

    /**
     * Get TVShow number of seasons
     * @return int
     */
    public function getNumberSeasons(): int;

    /**
     * Get TVShow status
     * @return string
     */
    public function getStatus() : string;

    /**
     * Get TVShow seasons
     * @return \Generator
     */
    public function getSeasons() : \Generator;

    /**
     * Get poster path
     */
    public function getPosterPath(): string;

    /**
     * Get backdrop path
     */
    public function getBackdropPath(): string;

}
