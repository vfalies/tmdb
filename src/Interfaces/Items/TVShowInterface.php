<?php

namespace vfalies\tmdb\Interfaces\Items;

interface TVShowInterface
{

    /**
     * Get TV show id
     * @return int
     */
    public function getId();

    /**
     * Get TVShow genres
     * @return array
     */
    public function getGenres();

    /**
     * Get TVShow title
     * @return string
     */
    public function getTitle();

    /**
     * Get TVShow overview
     * @return string
     */
    public function getOverview();

    /**
     * Get TVShow release date
     * @return string
     */
    public function getReleaseDate();

    /**
     * Get TVShow original title
     * @return string
     */
    public function getOriginalTitle();

    /**
     * Get TVShow note
     * @return float
     */
    public function getNote();

    /**
     * Get TVShow number of episodes
     * @return int
     */
    public function getNumberEpisodes();

    /**
     * Get TVShow number of seasons
     * @return int
     */
    public function getNumberSeasons();

    /**
     * Get TVShow status
     * @return string
     */
    public function getStatus();

    /**
     * Get TVShow seasons
     * @return \Generator
     */
    public function getSeasons();

    /**
     * Get poster path
     */
    public function getPosterPath();

    /**
     * Get backdrop path
     */
    public function getBackdropPath();
}
