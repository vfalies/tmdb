<?php

namespace Vfac\Tmdb\Results;

class Movie implements \Vfac\Tmdb\Interfaces\ResultsInterface
{

    private $id             = null;
    private $overview       = null;
    private $release_date   = null;
    private $original_title = null;
    private $title          = null;
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
            if (!property_exists($result, $property))
            {
                throw new \Exception('Incorrect input for ' . __CLASS__ . ' object. Property "' . $property . '" not found');
            }
        }

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
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    /**
     * Get movie title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get movie poster
     * @return string
     */
    public function getPoster()
    {
        return $this->poster_path;
    }

    /**
     * Get movie backdrop
     * @return string
     */
    public function getBackdrop()
    {
        return $this->backdrop_path;
    }

}
