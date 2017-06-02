<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Interfaces\CollectionInterface;
use vfalies\tmdb\Tmdb;

class Collection extends Item implements CollectionInterface
{

    // Private loaded data
    protected $data = null;
    protected $conf = null;
    protected $id   = null;
    protected $tmdb = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, $collection_id, array $options = array())
    {
        parent::__construct($tmdb, $collection_id, $options, 'collection');
    }

    /**
     * Get collection ID
     * @return int
     * @throws \Exception
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get collection name
     * @return string
     * @throws \Exception
     */
    public function getName(): string
    {
        if (isset($this->data->name))
        {
            return $this->data->name;
        }
        throw new \Exception('Collection name can not be found');
    }

    /**
     * Get collection parts
     * @return Generator|SearchMovieResult
     */
    public function getParts(): \Generator
    {
        if (!empty($this->data->parts))
        {
            foreach ($this->data->parts as $part)
            {
                $movie = new vfalies\tmdb\Results\Movie($this->tmdb, $part);
                yield $movie;
            }
        }
    }

}
