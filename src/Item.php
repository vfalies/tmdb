<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *

 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb;

use vfalies\tmdb\Items\Movie;
use vfalies\tmdb\Items\Collection;
use vfalies\tmdb\Items\TVShow;
use vfalies\tmdb\Items\People;
use vfalies\tmdb\Items\Company;

/**
 * Item class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Item
{
    /**
     * Tmdb object
     * @var \vfalies\tmdb\Tmdb
     */
    private $tmdb   = null;
    /**
     * Logger object
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     */

    public function __construct(Tmdb $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->logger;
    }

    /**
     * Get movie details
     * @param int $movie_id
     * @param array $options
     * @return \vfalies\tmdb\Items\Movie
     */
    public function getMovie($movie_id, array $options = array())
    {
        $this->logger->debug('Starting getting movie');
        $movie = new Movie($this->tmdb, $movie_id, $options);

        return $movie;
    }

    /**
     * Get collection details
     * @param int $collection_id
     * @param array $options
     * @return \vfalies\tmdb\Items\Collection
     */
    public function getCollection($collection_id, array $options = array())
    {
        $this->logger->debug('Starting getting collection');
        $collection = new Collection($this->tmdb, $collection_id, $options);

        return $collection;
    }

    /**
     * Get TV Show details
     * @param int $tv_id
     * @param array $options
     * @return \vfalies\tmdb\Items\TVShow
     */
    public function getTVShow($tv_id, array $options = array())
    {
        $this->logger->debug('Starting getting tvshow');
        $tv = new TVShow($this->tmdb, $tv_id, $options);

        return $tv;
    }

    /**
     * Get People details
     * @param int $people_id
     * @param array $options
     * @return \vfalies\tmdb\Items\People
     */
    public function getPeople($people_id, array $options = array())
    {
        $this->logger->debug('Starting getting people');
        $people = new People($this->tmdb, $people_id, $options);

        return $people;
    }

    /**
     * Get Company details
     * @param int $company_id
     * @param array $options
     * @return \vfalies\tmdb\Items\Company
     */
    public function getCompany($company_id, array $options = array())
    {
        $this->logger->debug('Starting getting company');
        $company = new Company($this->tmdb, $company_id, $options);

        return $company;
    }
}
