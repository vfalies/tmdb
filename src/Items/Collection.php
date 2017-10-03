<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\CollectionInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Results\Image;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a collection
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Collection extends Item implements CollectionInterface
{

    use ElementTrait;

    /**
     * Configuration
     * @var \stdClass
     */
    protected $conf = null;
    /**
     * Id
     * @var int
     */
    protected $id = null;
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $collection_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, $collection_id, array $options = array())
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
        if (isset($this->data->name))
        {
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
        if (!empty($this->data->parts))
        {
            foreach ($this->data->parts as $part)
            {
                $movie = new \vfalies\tmdb\Results\Movie($this->tmdb, $part);
                yield $movie;
            }
        }
    }

    /**
     * Get collection backdrops
     * @return \Generator|Results\Image
     */
    public function getBackdrops()
    {
        $data = $this->tmdb->sendRequest('/collection/' . (int) $this->id . '/images', null, $this->params);

        foreach ($data->backdrops as $b)
        {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get collection posters
     * @return \Generator|Results\Image
     */
    public function getPosters()
    {
        $data = $this->tmdb->sendRequest('/collection/' . (int) $this->id . '/images', null, $this->params);

        foreach ($data->posters as $b)
        {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }
}
