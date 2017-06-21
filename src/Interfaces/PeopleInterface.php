<?php

namespace vfalies\tmdb\Interfaces;

interface PeopleInterface
{

    public function getAdult();

    public function getAlsoKnownAs();

    public function getBiography();

    public function getBirthday();

    public function getDeathday();

    public function getGender();

    public function getHomepage();

    public function getId();

    public function getImdbId();

    public function getName();

    public function getPlaceOfBirth();

    public function getPopularity();

    public function getProfilePath();
}
