<?php

namespace Vfac\Tmdb\Results;

class Collection implements \Vfac\Tmdb\Interfaces\ResultsInterface
{

    private $id            = null;
    private $name          = null;
    private $poster_path   = null;
    private $backdrop_path = null;
    private $conf          = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(\Vfac\Tmdb\Tmdb $tmdb, \stdClass $result)
    {
        // Valid input object
        $properties = get_object_vars($this);
        foreach ($properties as $property => $value)
        {
            if ($property != 'conf' && ! property_exists($result, $property))
            {
                throw new \Exception('Incorrect input for '.__CLASS__.' object. Property "'.$property.'" not found');
            }
        }

        // Populate data
        $this->id            = $result->id;
        $this->name          = $result->name;
        $this->poster_path   = $result->poster_path;
        $this->backdrop_path = $result->backdrop_path;

        // Configuration
        $this->conf = $tmdb->getConfiguration();
    }

    /**
     * Get collection ID
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * Get collection name
     * @return string
     */
    public function getTitle(): string
    {
        return $this->name;
    }

    /**
     * Get collection poster
     * @return string
     */
    public function getPoster(string $size = 'w185'): string
    {
        if (isset($this->poster_path))
        {
            if ( ! isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if ( ! in_array($size, $this->conf->images->poster_sizes))
            {
                throw new \Exception('Incorrect poster size : '.$size);
            }
            return $this->conf->images->base_url.$size.$this->poster_path;
        }
        return '';
    }

    /**
     * Get collection backdrop
     * @return string
     */
    public function getBackdrop(string $size = 'w780'): string
    {
        if (isset($this->backdrop_path))
        {
            if ( ! isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if ( ! in_array($size, $this->conf->images->backdrop_sizes))
            {
                throw new \Exception('Incorrect backdrop size : '.$size);
            }
            return $this->conf->images->base_url.$size.$this->backdrop_path;
        }
        return '';
    }

    public function getOriginalTitle(): string
    {
        throw new \Exception('Not applicable');
    }

    public function getOverview(): string
    {
        throw new \Exception('Not applicable');
    }

    public function getReleaseDate(): string
    {
        throw new \Exception('Not applicable');
    }

}
