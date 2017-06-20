<?php

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
