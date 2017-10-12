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


namespace VfacTmdb;

use VfacTmdb\Items;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Item class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Item
{
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    private $tmdb = null;
    /**
     * Logger object
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     */

    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
    }

    /**
     * Get movie details
     * @param int $movie_id
     * @param array $options
     * @return Items\Movie
     */
    public function getMovie(int $movie_id, array $options = array()) : Items\Movie
    {
        $this->logger->debug('Starting getting movie', array('movie_id' => $movie_id, 'options' => $options));
        $movie = new Items\Movie($this->tmdb, $movie_id, $options);

        return $movie;
    }

    /**
     * Get collection details
     * @param int $collection_id
     * @param array $options
     * @return Items\Collection
     */
    public function getCollection(int $collection_id, array $options = array()) : Items\Collection
    {
        $this->logger->debug('Starting getting collection', array('collection_id' => $collection_id, 'options' => $options));
        $collection = new Items\Collection($this->tmdb, $collection_id, $options);

        return $collection;
    }

    /**
     * Get TV Show details
     * @param int $tv_id
     * @param array $options
     * @return Items\TVShow
     */
    public function getTVShow(int $tv_id, array $options = array()) : Items\TVShow
    {
        $this->logger->debug('Starting getting tvshow', array('tv_id' => $tv_id, 'options' => $options));
        $tv = new Items\TVShow($this->tmdb, $tv_id, $options);

        return $tv;
    }

    /**
     * Get People details
     * @param int $people_id
     * @param array $options
     * @return Items\People
     */
    public function getPeople(int $people_id, array $options = array()) : Items\People
    {
        $this->logger->debug('Starting getting people', array('people_id' => $people_id, 'options' => $options));
        $people = new Items\People($this->tmdb, $people_id, $options);

        return $people;
    }

    /**
     * Get Company details
     * @param int $company_id
     * @param array $options
     * @return Items\Company
     */
    public function getCompany(int $company_id, array $options = array()) : Items\Company
    {
        $this->logger->debug('Starting getting company', array('company_id' => $company_id, 'options' => $options));
        $company = new Items\Company($this->tmdb, $company_id, $options);

        return $company;
    }
}
