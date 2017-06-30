<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\TVShowResultsInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Traits\Results\ShowTrait;

class TVShow extends Results implements TVShowResultsInterface
{

    protected $backdrop_path  = null;
    protected $poster_path    = null;

    use ElementTrait;
    use ShowTrait;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        array_push($this->property_blacklist, 'release_date'); // For renaming first_air_date to release_date
        array_push($this->property_blacklist, 'original_title'); // For renaming original_name to original_title
        array_push($this->property_blacklist, 'title'); // For renaming name to title

        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->release_date   = $this->data->first_air_date;
        $this->original_title = $this->data->original_name;
        $this->title          = $this->data->name;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;
    }

//    /**
//     * Get tvshow ID
//     * @return int
//     */
//    public function getId()
//    {
//        return (int) $this->id;
//    }
//
//    /**
//     * Get tvshow overview
//     * @return string
//     */
//    public function getOverview()
//    {
//        return $this->overview;
//    }
//
//    /**
//     * Get tvshow first air date
//     * @return string
//     */
//    public function getReleaseDate()
//    {
//        return $this->release_date;
//    }
//
//    /**
//     * Get tvshow original name
//     * @return string
//     */
//    public function getOriginalTitle()
//    {
//        return $this->original_title;
//    }
//
//    /**
//     * Get tvshow name
//     * @return string
//     */
//    public function getTitle()
//    {
//        return $this->name;
//    }
}
