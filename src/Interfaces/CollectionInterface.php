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
    public function getPoster(string $size = 'w185'): string;

    /**
     * Get collection backdrop
     * @param string $size
     * @return string
     * @throws \Exception
     */
    public function getBackdrop(string $size = 'w780'): string;

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
