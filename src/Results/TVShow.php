<?php

namespace Vfac\Tmdb\Results;

class TVShow extends Results
{

    protected $overview       = null;
    protected $first_air_date = null;
    protected $original_name  = null;
    protected $name           = null;

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
        $this->first_air_date = $result->first_air_date;
        $this->original_name  = $result->original_name;
        $this->name           = $result->name;
        $this->poster_path    = $result->poster_path;
        $this->backdrop_path  = $result->backdrop_path;
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
