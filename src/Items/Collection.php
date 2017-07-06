<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\CollectionInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Traits\ElementTrait;

class Collection extends Item implements CollectionInterface
{

    use ElementTrait;

    // Private loaded data
    protected $data = null;
    protected $conf = null;
    protected $id   = null;
    protected $tmdb = null;

    /**
     * Constructor
     * @param Tmdb $tmdb
     * @param int $collection_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $collection_id, array $options = array())
    {
        parent::__construct($tmdb, $collection_id, $options, 'collection');
    }

    /**
     * Get collection ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get collection name
     * @return string
     * @throws NotFoundException
     */
    public function getName()
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        $this->logger->error('Collection name not found', array('collection_id' => $this->id));
        throw new NotFoundException;
    }

    /**
     * Get collection parts
     * @return Generator
     */
    public function getParts()
    {
        if (!empty($this->data->parts)) {
            foreach ($this->data->parts as $part) {
                $movie = new \vfalies\tmdb\Results\Movie($this->tmdb, $part);
                yield $movie;
            }
        }
    }
}
