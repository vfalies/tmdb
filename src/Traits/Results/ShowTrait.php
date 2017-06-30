<?php

namespace vfalies\tmdb\Traits\Results;

trait ShowTrait
{
    protected $id;
    protected $overview;
    protected $release_date;
    protected $original_title;
    protected $title;

     /**
     * Get show ID
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Get show overview
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Get show first air date
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * Get show original name
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    /**
     * Get show name
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

}
