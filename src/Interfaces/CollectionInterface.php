<?php

namespace vfalies\tmdb\Interfaces;

interface CollectionInterface
{

    /**
     * Get collection ID
     * @return int
     * @throws \Exception
     */
    public function getId(): int;

    /**
     * Get collection name
     * @return string
     * @throws \Exception
     */
    public function getName(): string;

    /**
     * Get collection poster
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getPoster($size = 'w185'): string;

    /**
     * Get collection backdrop
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getBackdrop($size = 'w780'): string;

    /**
     * Get collection parts
     * @return Generator|SearchMovieResult
     */
    public function getParts(): \Generator;
}
