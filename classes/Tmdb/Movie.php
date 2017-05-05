<?php

namespace Vfac\Tmdb;

class Movie
{
    // Private loaded data
    private $_data = null;
    private $_conf = null;

    /**
     * Constructor
     * @param stdClass $data
     * @param stdClass $configuration
     */
    public function __construct(\stdClass $data, \stdClass $configuration)
    {
        $this->_data = $data;
        $this->_conf = $configuration;
    }

    /**
     * Get movie title
     * @return string|null
     */
    public function getTitle()
    {
        if (isset($this->_data->title))
        {
            return $this->_data->title;
        }
        return null;
    }

    /**
     * Get movie overview
     * @return string|null
     */
    public function getOverview()
    {
        if (isset($this->_data->overview))
        {
            return $this->_data->overview;
        }
        return null;
    }

    /**
     * Get movie release date
     * @return string|null
     */
    public function getReleaseDate()
    {
        if (isset($this->_data->release_date))
        {
            return $this->_data->release_date;
        }
        return null;
    }

    /**
     * Get movie original title
     * @return string|null
     */
    public function getOriginalTitle()
    {
        if (isset($this->_data->original_title))
        {
            return $this->_data->original_title;
        }
        return null;
    }

    /**
     * Get movie note
     * @return number|null
     */
    public function getNote()
    {
        if (isset($this->_data->vote_average))
        {
            return $this->_data->vote_average;
        }
        return null;
    }

    /**
     * Get movie id
     * @return int|null
     */
    public function getId()
    {
        if (isset($this->_data->id))
        {
            return $this->_data->id;
        }
        return null;
    }

    /**
     * Get movie genres
     * @return array|null
     */
    public function getGenres()
    {
        if (isset($this->_data->genre_ids))
        {
            return var_export($this->_data->genre_ids, true);
        }
        return null;
    }

    /**
     * Get movie poster
     * @param string $size
     * @return string|null
     */
    public function getPoster($size = 'w185')
    {
        if (!isset($this->_conf->images->base_url))
        {
            throw new \Exception('base_url configuration not found');
        }
        if (!in_array($size, $this->_conf->images->poster_sizes))
        {
            throw new \Exception('Incorrect poster size : '.$size);
        }
        if (isset($this->_data->poster_path))
        {
            return $this->_conf->images->base_url.$size.$this->_data->poster_path;
        }
        return null;
    }

    /**
     * Get movie backdrop
     * @param string $size
     * @return string|null
     */
    public function getBackdrop($size = 'w780')
    {
        if (!isset($this->_conf->images->base_url))
        {
            throw new \Exception('base_url configuration not found');
        }
        if (!in_array($size, $this->_conf->images->backdrop_sizes))
        {
            throw new \Exception('Incorrect backdrop size : '.$size);
        }
        if (isset($this->_data->backdrop_path))
        {
            return $this->_conf->images->base_url.$size.$this->_data->backdrop_path;
        }
        return null;
    }

    /**
     * Magical method
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'raw':
                return var_export($this->_data, true);
            default:
                throw new \Exception("Unknown property ($name) for movie.");
        }
    }

}
