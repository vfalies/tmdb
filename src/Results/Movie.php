<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\MovieResultsInterface;

class Movie extends Results implements MovieResultsInterface
{
    protected $overview       = null;
    protected $release_date   = null;
    protected $original_title = null;
    protected $title          = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->release_date   = $this->data->release_date;
        $this->original_title = $this->data->original_title;
        $this->title          = $this->data->title;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;
    }

    /**
     * Get movie ID
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->original_title;
    }

    /**
     * Get movie title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

}
