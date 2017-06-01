<?php

namespace Vfac\Tmdb\Interfaces;

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
     * Get TVShow poster
     * @param string $size
     * @return string
     */
    public function getPoster(string $size = 'w185'): string;

    /**
     * Get TVShow backdrop
     * @param string $size
     * @return string
     */
    public function getBackdrop(string $size = 'w780'): string;

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
     * @throws \Exception
     */
    public function getSeasons() : \Generator;

}
