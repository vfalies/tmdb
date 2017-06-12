<?php

namespace vfalies\tmdb\Interfaces;

interface PeopleInterface
{

    public function getAdult(): bool;

    public function getAlsoKnownAs(): array;

    public function getBiography() : string;

    public function getBirthday() : string;

    public function getDeathday() : string;

    public function getGender() : int;

    public function getHomepage() : string;

    public function getId() : int;

    public function getImdbId() : int;

    public function getName() : int;

    public function getPlaceOfBirth() : string;

    public function getPopularity() : float;

    public function getProfilePath() : string;
}
