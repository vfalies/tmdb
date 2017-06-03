<?php

namespace vfalies\tmdb\Results;
use vfalies\tmdb\Tmdb;

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
    public function __construct(Tmdb $tmdb, \stdClass $result)
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
        return $this->getImage('poster', $size);
    }

    /**
     * Get backdrop
     * @return string
     */
    public function getBackdrop(string $size = 'w780'): string
    {
        return $this->getImage('backdrop', $size);
    }

    /**
     * Get image url from type and size
     * @param string $type
     * @param string $size
     * @return string
     * @throws \Exception
     */
    private function getImage(string $type, string $size) : string
    {
        $path = $type . '_path';
        if (isset($this->$path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            $sizes = $type . '_sizes';
            if (!in_array($size, $this->conf->images->$sizes))
            {
                throw new \Exception('Incorrect '.$type.' size : ' . $size);
            }
            return $this->conf->images->base_url . $size . $this->data->$path;
        }
        return '';
    }
}
