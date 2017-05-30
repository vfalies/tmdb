<?php

namespace Vfac\Tmdb;

class Collection
{

    // Private loaded data
    private $data = null;
    private $conf = null;
    private $id   = null;
    private $tmdb = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     * @throws \Exception
     */
    public function __construct(\Vfac\Tmdb\Tmdb $tmdb, $collection_id, array $options = array())
    {
        try
        {
            $this->id   = (int) $collection_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();

            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest('collection/' . (int) $collection_id, null, $params);
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get collection name
     * @return string
     * @throws \Exception
     */
    public function getName(): string
    {
        if (isset($this->data->name))
        {
            return $this->data->name;
        }
        throw new \Exception('Collection name can not be found');
    }

    /**
     * Get collection poster
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getPoster($size = 'w185'): string
    {
        if (isset($this->data->poster_path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if (!in_array($size, $this->conf->images->poster_sizes))
            {
                throw new \Exception('Incorrect poster size : ' . $size);
            }
            return $this->conf->images->base_url . $size . $this->data->poster_path;
        }
        throw new \Exception('Collection poster path can not be found');
    }

    /**
     * Get collection backdrop
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getBackdrop($size = 'w780'): string
    {
        if (isset($this->data->backdrop_path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if (!in_array($size, $this->conf->images->backdrop_sizes))
            {
                throw new \Exception('Incorrect backdrop size : ' . $size);
            }
            return $this->conf->images->base_url . $size . $this->data->backdrop_path;
        }
        throw new \Exception('Collection backdrop path can not be found');
    }

    /**
     * Get collection parts
     * @return Generator|SearchMovieResult
     */
    public function getParts(): \Generator
    {
        if (!empty($this->data->parts))
        {
            foreach ($this->data->parts as $part)
            {
                $movie = new Results\Movie($this->tmdb, $part);
                yield $movie;
            }
        }
    }

}
