<?php declare(strict_types=1);
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


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Interfaces\Items\CollectionInterface;

use VfacTmdb\Exceptions\NotFoundException;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Results;
use VfacTmdb\Interfaces\TmdbInterface;

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
    public function __construct(TmdbInterface $tmdb, int $collection_id, array $options = array())
    {
        parent::__construct($tmdb, $collection_id, $options, 'collection');

        $this->setElementTrait($this->data);
    }

    /**
     * Get collection ID
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get collection name
     * @return string
     * @throws NotFoundException
     */
    public function getName() : string
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        $this->logger->error('Collection name not found', array('collection_id' => $this->id));
        throw new NotFoundException;
    }

    /**
     * Get collection parts
     * @return \Generator
     */
    public function getParts() : \Generator
    {
        if (!empty($this->data->parts)) {
            foreach ($this->data->parts as $part) {
                $movie = new Results\Movie($this->tmdb, $part);
                yield $movie;
            }
        }
    }

    /**
     * Get collection backdrops
     * @return \Generator|Results\Image
     */
    public function getBackdrops() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('collection/' . (int) $this->id . '/images', $params);

        foreach ($data->backdrops as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get collection posters
     * @return \Generator|Results\Image
     */
    public function getPosters() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('collection/' . (int) $this->id . '/images', $params);

        foreach ($data->posters as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }
}
