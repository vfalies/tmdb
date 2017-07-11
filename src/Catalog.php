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

class Catalog
{

    private $tmdb   = null;
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
}
