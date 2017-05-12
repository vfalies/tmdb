<?php

namespace Vfac\Tmdb;

class Search
{

    private $_tmdb = null;
    private $_conf = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     */
    public function __construct(Tmdb $tmdb)
    {
        $this->_tmdb = $tmdb;
        $this->_conf = $this->_tmdb->getConfiguration();
    }

    /**
     * Search a movie
     * @param string $query Query string to search like a movie
     * @param array $options Array of options for the search
     * @return Generator|SearchMovieResult
     * @throws \Exception
     */
    public function searchMovie($query, array $options = array())
    {
        try
        {
            $query = trim($query);
            if (empty($query))
            {
                throw new \Exception('query parameter can not be empty');
            }
            $params   = $this->_tmdb->checkOptions($options);
            $response = $this->_tmdb->sendRequest('search/movie', $query, $params);

            foreach ($response->results as $result)
            {
                $movie = new SearchMovieResult($result);

                yield $movie;
            }
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Search a TV Show
     * @param string $query Query string to search like a TV Show
     * @param array $options Array of options for the request
     * @return Generator|SearchTVShowResult
     */
    public function searchTVShow($query, array $options = array())
    {
        try
        {
            $query = trim($query);
            if (empty($query))
            {
                throw new \Exception('query parameter can not be empty');
            }
            $params   = $this->checkOptions($options);
            $response = $this->sendRequest('search/tv', $query, $params);

            foreach ($response->results as $result)
            {
                $tvshow = new SearchTVShowResult($result);

                yield $tvshow;
            }
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get movie details
     * @param int $movie_id
     * @param array $options
     * @return \Vfac\Tmdb\Movie
     */
    public function getMovie($movie_id, array $options = array())
    {
        $movie = new Movie($this->_tmdb, $movie_id, $options);

        return $movie;
    }

    /**
     * Get collection details
     * @param int $collection_id
     * @param array $options
     * @return \Vfac\Tmdb\Collection
     */
    public function getCollection($collection_id, array $options = array())
    {
        $collection = new Collection($this->_tmdb, $collection_id, $options);

        return $collection;
    }

    /**
     * Get TV Show details
     * @param int $tv_id
     * @param array $options
     * @return \Vfac\Tmdb\TVShow
     */
    public function getTVShow($tv_id, array $options = array())
    {
        $tv = new TVShow($this->_tmdb, $tv_id, $options);

        return $tv;
    }

}
