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
    private $conf           = null;

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
        $this->id             = $result->id;
        $this->overview       = $result->overview;
        $this->release_date   = $result->release_date;
        $this->original_title = $result->original_title;
        $this->title          = $result->title;
        $this->poster_path    = $result->poster_path;
        $this->backdrop_path  = $result->backdrop_path;

        // Configuration
        $this->conf = $tmdb->getConfiguration();
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

    /**
     * Get movie poster
     * @param string $size
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
     * Get movie backdrop
     * @param string $size
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

}
