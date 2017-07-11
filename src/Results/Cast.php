<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Interfaces\Results\CastResultsInterface;
use vfalies\tmdb\Tmdb;

class Cast extends Results implements CastResultsInterface
{

    protected $character    = null;
    protected $gender       = null;
    protected $credit_id    = null;
    protected $cast_id      = null;
    protected $name         = null;
    protected $profile_path = null;
    protected $order        = null;
    protected $id           = null;

    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id           = $this->data->id;
        $this->character    = $this->data->character;
        $this->gender       = $this->data->gender;
        $this->credit_id    = $this->data->credit_id;
        $this->cast_id      = $this->data->cast_id;
        $this->name         = $this->data->name;
        $this->profile_path = $this->data->profile_path;
        $this->order        = $this->data->order;
    }

    public function getId()
    {
        return (int) $this->id;
    }

    public function getCreditId()
    {
        return $this->credit_id;
    }

    public function getCharacter()
    {
        return $this->character;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getCastId()
    {
        return $this->cast_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProfilePath()
    {
        return $this->profile_path;
    }

    public function getOrder()
    {
        return $this->order;
    }

}
