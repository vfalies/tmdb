<?php

namespace vfalies\tmdb\Interfaces\Items;

interface CollectionInterface
{

    /**
     * Get collection ID
     * @return int
     */
    public function getId(): int;

    /**
     * Get collection name
     * @return string
     */
    public function getName(): string;

    /**
     * Get collection parts
     * @return Generator|SearchMovieResult
     */
    public function getParts(): \Generator;

    /**
     * Get poster path
     */
    public function getPosterPath(): string;

    /**
     * Get backdrop path
     */
    public function getBackdropPath(): string;

}
