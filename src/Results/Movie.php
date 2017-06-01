<?php

namespace Vfac\Tmdb\Results;

class Movie extends Results
{
    protected $overview       = null;
    protected $release_date   = null;
    protected $original_title = null;
    protected $title          = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(\Vfac\Tmdb\Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $result->id;
        $this->overview       = $result->overview;
        $this->release_date   = $result->release_date;
        $this->original_title = $result->original_title;
        $this->title          = $result->title;
        $this->poster_path    = $result->poster_path;
        $this->backdrop_path  = $result->backdrop_path;
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
