<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Items\Movie;
use vfalies\tmdb\Items\Collection;
use vfalies\tmdb\Items\TVShow;
use vfalies\tmdb\Items\People;

class Item
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

}
