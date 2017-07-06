<?php

namespace vfalies\tmdb\Interfaces\Results;

interface CastResultsInterface {

    public function getCreditId();

    public function getCharacter();

    public function getGender();

    public function getCastId();

    public function getName();

    public function getProfilePath();

    public function getOrder();
}