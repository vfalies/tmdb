<?php

namespace vfalies\tmdb\Interfaces\Results;

interface CollectionResultsInterface extends ResultsInterface
{

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview();

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle();

    /**
     * Get movie title
     * @return string
     */
    public function getTitle();

    /**
     * Get movie backdrop
     * @return string
     */
    public function getBackdrop();
}
