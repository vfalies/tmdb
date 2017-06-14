<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;

class TVShow extends Results
{

    protected $overview       = null;
    protected $first_air_date = null;
    protected $original_name  = null;
    protected $name           = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->first_air_date = $this->data->first_air_date;
        $this->original_name  = $this->data->original_name;
        $this->name           = $this->data->name;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;
    }

    /**
     * Get tvshow ID
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * Get tvshow overview
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * Get tvshow first air date
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->first_air_date;
    }

    /**
     * Get tvshow original name
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->original_name;
    }

    /**
     * Get tvshow name
     * @return string
     */
    public function getTitle(): string
    {
        return $this->name;
    }

}
