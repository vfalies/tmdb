<?php

namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\IncorrectParamException;

abstract class Element
{
    protected $data = null;
    protected $conf = null;

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
     * @throws IncorrectParamException
     * @throws NotFoundException
     */
    private function getImage(string $type, string $size): string
    {
        $path = $type . '_path';
        if (isset($this->data->$path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new NotFoundException;
            }
            $sizes = $type . '_sizes';
            if (!in_array($size, $this->conf->images->$sizes))
            {
                throw new IncorrectParamException;
            }
            return $this->conf->images->base_url . $size . $this->data->$path;
        }
        return '';
    }

}
