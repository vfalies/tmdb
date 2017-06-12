<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;

class People extends Results
{

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);
    }

    public function getId(): int
    {
        return (int) $this->data->id;
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

    public function getTitle(): string
    {
        throw new \Exception('Not applicable');
    }

}
