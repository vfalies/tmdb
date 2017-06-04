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
            $this->data = $this->tmdb->sendRequest(new CurlRequest(), $item_name . '/' . (int) $item_id, null, $params);
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
        return $this->getImage('poster', $size);
    }

    /**
     * Get item backdrop
     * @param string $size
     * @return string|null
     */
    public function getBackdrop(string $size = 'w780'): string
    {
        return $this->getImage('backdrop', $size);
    }

    /**
     * Get poster path
     */
    public function getPosterPath(): string
    {
        if (isset($this->data->poster_path))
        {
            return $this->data->poster_path;
        }
        return '';
    }

    /**
     * Get backdrop
     */
    public function getBackdropPath(): string
    {
        if (isset($this->data->backdrop_path))
        {
            return $this->data->backdrop_path;
        }
        return '';
    }

    /**
     * Get image url from type and size
     * @param string $type
     * @param string $size
     * @return string
     * @throws \Exception
     */
    private function getImage(string $type, string $size): string
    {
        $path = $type . '_path';
        if (isset($this->data->$path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            $sizes = $type . '_sizes';
            if (!in_array($size, $this->conf->images->$sizes))
            {
                throw new \Exception('Incorrect ' . $type . ' size : ' . $size);
            }
            return $this->conf->images->base_url . $size . $this->data->$path;
        }
        return '';
    }

}
