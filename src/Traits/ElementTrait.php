<?php

namespace vfalies\tmdb\Traits;

trait ElementTrait
{
    protected $data;

    /**
     * Get poster path
     */
    public function getPosterPath()
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
    public function getBackdropPath()
    {
        if (isset($this->data->backdrop_path))
        {
            return $this->data->backdrop_path;
        }
        return '';
    }

}
