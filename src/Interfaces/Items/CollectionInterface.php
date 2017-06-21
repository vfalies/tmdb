<?php

namespace vfalies\tmdb\Interfaces\Items;

interface CollectionInterface
{

    /**
     * Get collection ID
     * @return int
     */
    public function getId();

    /**
     * Get collection name
     * @return string
     */
    public function getName();

    /**
     * Get collection parts
     * @return Generator|SearchMovieResult
     */
    public function getParts();

    /**
     * Get poster path
     */
    public function getPosterPath();

    /**
     * Get backdrop path
     */
    public function getBackdropPath();
}
