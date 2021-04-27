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


namespace VfacTmdb\Abstracts\Items;

use VfacTmdb\Results;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Abstract Item Changes class
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2021
 */
abstract class ItemChanges
{
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;
    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;
    /**
     * Params
     * @var array
     */
    protected $params = [];
    /**
     * Data
     * @var \stdClass
     */
    protected $data = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param string $item_type (possible values: movie, person, tv, tv/season, tv/episode)
     * @param int $item_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, string $item_type, int $item_id, array $options = array())
    {
        try {
            $this->tmdb   = $tmdb;
            $this->logger = $tmdb->getLogger();

            $this->logger->debug('Starting Item Changes', array('item_type' => $item_type, 'item_id' => $item_id, 'options' => $options));

            $this->tmdb->checkOptionDateRange($options, $this->params);

            $this->data = $this->tmdb->getRequest($item_type . '/' . $item_id . '/changes', $this->params);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Get ItemChanges
     * @return \Generator|Results\ItemChange
     */
    public function getChanges() : \Generator
    {
        if (!empty($this->data->changes)) {
            foreach ($this->data->changes as $change) {
                foreach ($change->items as $item) {
                    $item->key = $change->key;
                    $itemChange = new Results\ItemChange($this->tmdb, $item);
                    yield $itemChange;
                }
            }
        }
    }

    /**
     * Get ItemChanges by key
     * @param string $key
     * @return \Generator|Results\ItemChange
     */
    public function getChangesByKey(string $key) : \Generator
    {
        $itemChanges = $this->getChanges();
        foreach ($itemChanges as $change) {
            if ($change->getKey() === $key) {
                yield $change;
            }
        }
    }

    /**
     * Get all ItemChange keys
     * @return array
     */
    public function getChangeKeys() : array
    {
        $changeKeys = [];
        $itemChanges = $this->getChanges();
        foreach ($itemChanges as $change) {
            $changeKeys[] = $change->getKey();
        }

        return $changeKeys;
    }
}
