<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Interfaces\Results\CrewResultsInterface;
use vfalies\tmdb\Tmdb;

class Crew extends Results implements CrewResultsInterface
{

    protected $department   = null;
    protected $gender       = null;
    protected $credit_id    = null;
    protected $job          = null;
    protected $name         = null;
    protected $profile_path = null;

    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id           = $this->data->id;
        $this->department   = $this->data->department;
        $this->gender       = $this->data->gender;
        $this->credit_id    = $this->data->credit_id;
        $this->job          = $this->data->job;
        $this->name         = $this->data->name;
        $this->profile_path = $this->data->profile_path;
    }

    public function getId()
    {
        return (int) $this->id;
    }

    public function getCreditId()
    {
        return $this->credit_id;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getJob()
    {
        return $this->job;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProfilePath()
    {
        return $this->profile_path;
    }

}
