<?php

namespace vfalies\tmdb\Interfaces\Items;

interface TVEpisodeInterface
{
    public function getId();

    public function getAirDate();

    public function getSeasonNumber();

    public function getName();

    public function getOverview();

    public function getCrew();

    public function getEpisodeNumber();

    public function getGuestStars();

    public function getProductionCode();

    public function getStillPath();

    public function getNote();

    public function getNoteCount();
}
