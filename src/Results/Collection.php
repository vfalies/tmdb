<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\CollectionResultsInterface;
use vfalies\tmdb\Exceptions\NotApplicableException;

class Collection extends Results implements CollectionResultsInterface
{

    protected $name          = null;
    protected $poster_path   = null;
    protected $backdrop_path = null;

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
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * Get collection name
     * @return string
     */
    public function getTitle(): string
    {
        return $this->name;
    }

    public function getOriginalTitle(): string
    {
        throw new NotApplicableException;
    }

    public function getOverview(): string
    {
        throw new NotApplicableException;
    }

    public function getReleaseDate(): string
    {
        throw new NotApplicableException;
    }

}
