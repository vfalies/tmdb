<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\PeopleResultsInterface;

class People extends Results implements PeopleResultsInterface
{

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);
    }

    public function getId()
    {

    }

    public function getAdult()
    {

    }

    public function getKnownFor()
    {

    }

    public function getName()
    {

    }

    public function getPopularity()
    {

    }

    public function getProfilePath()
    {

    }

}
