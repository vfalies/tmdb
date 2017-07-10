<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;

class Image extends Results
{
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);
    }

    public function getId()
    {
        return (int) $this->id;
    }

    public function getAspectRatio()
    {
        return $this->aspect_ratio;
    }

    public function getFilePath()
    {
        return $this->file_path;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getIso6391()
    {
        return $this->iso_639_1;
    }

    public function getVoteAverage()
    {
        return $this->vote_average;
    }

    public function getVoteCount()
    {
        return $this->vote_count;
    }

    public function getWidth()
    {
        return $this->width;
    }
}
