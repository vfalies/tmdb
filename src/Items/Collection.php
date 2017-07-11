<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\CollectionInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Results\Movie;
use vfalies\tmdb\Results\Image;

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
                $movie = new Movie($this->tmdb, $part);
                yield $movie;
            }
        }
    }

    public function getBackdrops()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/collection/'.(int) $this->id.'/images', null, $this->params);

        foreach ($data->backdrops as $b)
        {
            $image = new Image($this->tmdb, $b);
            yield $image;
        }
    }

    public function getPosters()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/collection/'.(int) $this->id.'/images', null, $this->params);

        foreach ($data->posters as $b)
        {
            $image = new Image($this->tmdb, $b);
            yield $image;
        }
    }
}
