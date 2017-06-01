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
        foreach (array_keys($properties) as $property)
        {
            if ($property != 'conf' && ! property_exists($result, $property))
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

        // Configuration
        $this->conf = $tmdb->getConfiguration();
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

    /**
     * Get tvshow poster
     * @return string
     */
    public function getPoster(string $size = 'w185'): string
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

    /**
     * Get tvshow backdrop
     * @return string
     */
    public function getBackdrop(string $size = 'w780'): string
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

}
