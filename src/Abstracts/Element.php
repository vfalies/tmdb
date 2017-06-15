<?php

namespace vfalies\tmdb\Abstracts;

abstract class Element
{
    protected $data = null;
    protected $conf = null;

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

}
