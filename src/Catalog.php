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

use vfalies\tmdb\Catalogs\Genres;
use vfalies\tmdb\Catalogs\Jobs;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Catalog class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Catalog
{
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    private $tmdb   = null;
    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * Constructor
     * @param vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
    }

    /**
     * Get movie genres list
     * @param array $options
     * @return \Generator
     */
    public function getMovieGenres(array $options = array())
    {
        $this->logger->debug('Starting getting movie genres');
        $catalog = new Genres($this->tmdb);
        return $catalog->getMovieList($options);
    }

    /**
     * Get TVShow genres list
     * @param array $options
     * @return \Generator
     */
    public function getTVShowGenres(array $options = array())
    {
        $this->logger->debug('Starting getting tv show genres');
        $catalog = new Genres($this->tmdb);
        return $catalog->getTVList($options);
    }

    /**
     * Get Job list
     * @param array $options
     * @return \Generator|\stdClass
     */
    public function getJobsList(array $options = array())
    {
        $this->logger->debug('Starting getting jobs list');
        $catalog = new Jobs($this->tmdb);
        return $catalog->getList($options);
    }
}
