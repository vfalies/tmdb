<?php

namespace Vfac\Tmdb\Results;

class TVShow implements \Vfac\Tmdb\Interfaces\ResultsInterface
{

    private $id             = null;
    private $overview       = null;
    private $first_air_date = null;
    private $original_name  = null;
    private $name           = null;
    private $poster_path    = null;
    private $backdrop_path  = null;

    /**
     * Constructor
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(\stdClass $result)
    {
        // Valid input object
        $properties = get_object_vars($this);
        foreach ($properties as $property => $value)
        {
            if ( ! property_exists($result, $property))
            {
                throw new \Exception('Incorrect input for '.__CLASS__.' object. Property "'.$property.'" not found');
            }
        }

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
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Get tvshow overview
     * @return string
     */
    public function getOverview() : string
    {
        return $this->overview;
    }

    /**
     * Get tvshow first air date
     * @return string
     */
    public function getReleaseDate() : string
    {
        return $this->first_air_date;
    }

    /**
     * Get tvshow original name
     * @return string
     */
    public function getOriginalTitle() : string
    {
        return $this->original_name;
    }

    /**
     * Get tvshow name
     * @return string
     */
    public function getTitle() : string
    {
        return $this->name;
    }

    /**
     * Get tvshow poster
     * @return string
     */
    public function getPoster() : string
    {
        return $this->poster_path;
    }

    /**
     * Get tvshow backdrop
     * @return string
     */
    public function getBackdrop() : string
    {
        return $this->backdrop_path;
    }
}
