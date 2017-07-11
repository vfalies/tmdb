<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\CollectionResultsInterface;
use vfalies\tmdb\Traits\ElementTrait;

class Collection extends Results implements CollectionResultsInterface
{

    use ElementTrait;

    protected $name          = null;
    protected $poster_path   = null;
    protected $backdrop_path = null;
    protected $id            = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id            = $this->data->id;
        $this->name          = $this->data->name;
        $this->poster_path   = $this->data->poster_path;
        $this->backdrop_path = $this->data->backdrop_path;
    }

    /**
     * Get collection ID
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Get collection name
     * @return string
     */
    public function getTitle()
    {
        return $this->name;
    }

}
