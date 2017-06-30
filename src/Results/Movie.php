<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\MovieResultsInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Traits\Results\ShowTrait;

class Movie extends Results implements MovieResultsInterface
{
    protected $poster_path    = null;
    protected $backdrop_path  = null;

    use ElementTrait;
    use ShowTrait;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->release_date   = $this->data->release_date;
        $this->original_title = $this->data->original_title;
        $this->title          = $this->data->title;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;
    }

//    /**
//     * Get movie ID
//     * @return int
//     */
//    public function getId()
//    {
//        return (int) $this->id;
//    }
//
//    /**
//     * Get movie overview
//     * @return string
//     */
//    public function getOverview()
//    {
//        return $this->overview;
//    }
//
//    /**
//     * Get movie release date
//     * @return string
//     */
//    public function getReleaseDate()
//    {
//        return $this->release_date;
//    }
//
//    /**
//     * Get movie original title
//     * @return string
//     */
//    public function getOriginalTitle()
//    {
//        return $this->original_title;
//    }
//
//    /**
//     * Get movie title
//     * @return string
//     */
//    public function getTitle()
//    {
//        return $this->title;
//    }
}
