<?php

namespace Vfac\Tmdb;

class Collection
{

    // Private loaded data
    private $_data = null;
    private $_conf = null;
    private $id    = null;
    private $_tmdb = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     * @throws \Exception
     */
    public function __construct(\Vfac\Tmdb\Tmdb $tmdb, $collection_id, array $options = array())
    {
        try
        {
            $this->id    = (int) $collection_id;
            $this->_tmdb = $tmdb;
            $this->_conf = $this->_tmdb->getConfiguration();

            $params      = $this->_tmdb->checkOptions($options);
            $this->_data = $this->_tmdb->sendRequest('collection/'.(int) $collection_id, null, $params);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get collection ID
     * @return int
     * @throws \Exception
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get collection name
     * @return string
     * @throws \Exception
     */
    public function getName()
    {
        if (isset($this->_data->name))
        {
            return $this->_data->name;
        }
        throw new \Exception('Collection name can not be found');
    }

    /**
     * Get collection poster
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getPoster($size = 'w185')
    {
        if (isset($this->_data->poster_path))
        {
            if ( ! isset($this->_conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if ( ! in_array($size, $this->_conf->images->poster_sizes))
            {
                throw new \Exception('Incorrect poster size : '.$size);
            }
            return $this->_conf->images->base_url.$size.$this->_data->poster_path;
        }
        throw new \Exception('Collection poster path can not be found');
    }

    /**
     * Get collection backdrop
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getBackdrop($size = 'w780')
    {
        if (isset($this->_data->backdrop_path))
        {
            if ( ! isset($this->_conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if ( ! in_array($size, $this->_conf->images->backdrop_sizes))
            {
                throw new \Exception('Incorrect backdrop size : '.$size);
            }
            return $this->_conf->images->base_url.$size.$this->_data->backdrop_path;
        }
        throw new \Exception('Collection backdrop path can not be found');
    }

    /**
     * Get collection parts
     * @return Generator|SearchMovieResult
     */
    public function getParts()
    {
        if ( ! empty($this->_data->parts))
        {
            foreach ($this->_data->parts as $part)
            {
                $movie = new SearchMovieResult($part);
                yield $movie;
            }
        }
        return null;
    }

}
