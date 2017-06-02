<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\CurlRequest;

abstract class Item
{
    protected $data = null;
    protected $conf = null;
    protected $id   = null;
    protected $tmdb = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $item_id
     * @param array $options
     * @param string $item_name
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, int $item_id, array $options, string $item_name)
    {
        try
        {
            $this->id   = (int) $item_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();
            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest(new CurlRequest(), $item_name . '/'.(int) $item_id, null, $params);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get item poster
     * @param string $size
     * @return string
     */
    public function getPoster(string $size = 'w185'): string
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
        return '';
    }

    /**
     * Get item backdrop
     * @param string $size
     * @return string|null
     */
    public function getBackdrop(string $size = 'w780'): string
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
        return '';
    }

}
