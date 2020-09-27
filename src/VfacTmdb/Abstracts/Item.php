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


namespace VfacTmdb\Abstracts;

use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * abstract item class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
abstract class Item
{
    /**
     * id
     * @var int
     */
    protected $id = null;
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
     * Configuration
     * @var \stdClass
     */
    protected $conf = null;
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
     * @param int $item_id
     * @param array $options
     * @param string $item_name
     * @throws \Exception
     */
    public function __construct(TmdbInterface $tmdb, int $item_id, array $options, string $item_name)
    {
        try {
            $this->id     = $item_id;
            $this->tmdb   = $tmdb;
            $this->logger = $tmdb->getLogger();
            $this->conf   = $this->tmdb->getConfiguration();
            $this->tmdb->checkOptionLanguage($options, $this->params);

            $this->data   = $this->tmdb->getRequest($item_name . '/' . (int) $item_id, $this->params);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
