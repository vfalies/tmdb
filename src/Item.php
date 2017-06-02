<?php

namespace vfalies\tmdb;

class Item
{
    private $tmdb          = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     */

    public function __construct(Tmdb $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Get movie details
     * @param int $movie_id
     * @param array $options
     * @return \vfalies\tmdb\Items\Movie
     */
    public function getMovie(int $movie_id, array $options = array()): Items\Movie
    {
        $movie = new Items\Movie($this->tmdb, $movie_id, $options);

        return $movie;
    }

    /**
     * Get collection details
     * @param int $collection_id
     * @param array $options
     * @return \vfalies\tmdb\Items\Collection
     */
    public function getCollection(int $collection_id, array $options = array()): Items\Collection
    {
        $collection = new Items\Collection($this->tmdb, $collection_id, $options);

        return $collection;
    }

    /**
     * Get TV Show details
     * @param int $tv_id
     * @param array $options
     * @return \vfalies\tmdb\Items\TVShow
     */
    public function getTVShow(int $tv_id, array $options = array()): Items\TVShow
    {
        $tv = new Items\TVShow($this->tmdb, $tv_id, $options);

        return $tv;
    }


}
