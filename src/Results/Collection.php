<?php

namespace Vfac\Tmdb\Results;

class Collection implements \Vfac\Tmdb\Interfaces\Results
{

    private $id            = null;
    private $name          = null;
    private $poster_path   = null;
    private $backdrop_path = null;

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
        $this->id            = $result->id;
        $this->name          = $result->name;
        $this->poster_path   = $result->poster_path;
        $this->backdrop_path = $result->backdrop_path;
    }

    /**
     * Get collection ID
     * @return int
     */
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Get collection name
     * @return string
     */
    public function getTitle() : string
    {
        return $this->name;
    }

    /**
     * Get collection poster
     * @return string
     */
    public function getPoster() : string
    {
        return $this->poster_path;
    }

    /**
     * Get collection backdrop
     * @return string
     */
    public function getBackdrop() : string
   {
        return $this->backdrop_path;
    }

    public function getOriginalTitle(): string
    {
        return $this->name;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getReleaseDate(): string
    {
        throw new Exception('Not applicable');
    }
}
