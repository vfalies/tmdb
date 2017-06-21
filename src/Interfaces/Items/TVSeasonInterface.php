<?php

namespace vfalies\tmdb\Interfaces\Items;

interface TVSeasonInterface
{
    public function getId();

    public function getPosterPath();

    public function getEpisodeCount();

    public function getEpisodes();

    public function getAirDate();

    public function getSeasonNumber();

    public function getName();

    public function getOverview();
}
