<?php

namespace vfalies\tmdb\Interfaces\Results;

interface PeopleResultsInterface extends ResultsInterface
{
    public function getProfilePath();

    public function getAdult();

    public function getKnownFor();

    public function getName();

    public function getPopularity();
}