<?php

namespace vfalies\tmdb\Interfaces\Results;

interface CollectionResultsInterface extends ResultsInterface
{
    /**
     * Get movie title
     * @return string
     */
    public function getTitle();
}
