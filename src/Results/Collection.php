<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Tmdb;

class Collection extends Results
{

    protected $name = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id            = $result->id;
        $this->name          = $result->name;
        $this->poster_path   = $result->poster_path;
        $this->backdrop_path = $result->backdrop_path;
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
        throw new \Exception('Not applicable');
    }

    public function getOverview(): string
    {
        throw new \Exception('Not applicable');
    }

    public function getReleaseDate(): string
    {
        throw new \Exception('Not applicable');
    }

}
