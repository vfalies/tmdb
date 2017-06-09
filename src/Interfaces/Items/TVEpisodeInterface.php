<?php

namespace vfalies\tmdb\Interfaces\Items;

interface TVEpisodeInterface
{
    public function getId(): int;

    public function getAirDate() : string;

    public function getSeasonNumber() : int;

    public function getName() : string;

    public function getOverview() : string;

    public function getCrew() : \Generator;

    public function getEpisodeNumber() : int;

    public function getGuestStars() : \Generator;

    public function getProductionCode() : string;

    public function getStillPath(): string;

    public function getNote(): float;

    public function getNoteCount(): float;
}