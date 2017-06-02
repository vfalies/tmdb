<?php

namespace vfalies\tmdb\Results;

abstract class Results implements \vfalies\tmdb\Interfaces\ResultsInterface
{

    protected $id            = null;
    protected $poster_path   = null;
    protected $backdrop_path = null;
    protected $conf          = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(\vfalies\tmdb\Tmdb $tmdb, \stdClass $result)
    {
        // Valid input object
        $properties = get_object_vars($this);
        foreach (array_keys($properties) as $property)
        {
            if ($property != 'conf' && !property_exists($result, $property))
            {
                throw new \Exception('Incorrect input for ' . __CLASS__ . ' object. Property "' . $property . '" not found');
            }
        }

        // Configuration
        $this->conf = $tmdb->getConfiguration();
    }

    /**
     * Get poster
     * @return string
     */
    public function getPoster(string $size = 'w185'): string
    {
        if (!isset($this->conf->images->base_url))
        {
            throw new \Exception('base_url configuration not found');
        }
        if (!in_array($size, $this->conf->images->poster_sizes))
        {
            throw new \Exception('Incorrect poster size : ' . $size);
        }
        return $this->conf->images->base_url . $size . $this->poster_path;
    }

    /**
     * Get backdrop
     * @return string
     */
    public function getBackdrop(string $size = 'w780'): string
    {
        if (!isset($this->conf->images->base_url))
        {
            throw new \Exception('base_url configuration not found');
        }
        if (!in_array($size, $this->conf->images->backdrop_sizes))
        {
            throw new \Exception('Incorrect backdrop size : ' . $size);
        }
        return $this->conf->images->base_url . $size . $this->backdrop_path;
    }

}
