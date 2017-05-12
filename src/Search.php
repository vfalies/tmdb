<?php

namespace Vfac\Tmdb;

class Search
{

    private $_tmdb         = null;
    private $_conf         = null;
    private $page          = 1; // Page number of the search result
    private $total_pages   = 1; // Total pages of the search result
    private $total_results = 1; // Total results of the search result

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
     * Search specify item
     * @param string $item item to search : movie / tv / collection
     * @param string $query Query string to search like a $item
     * @param array $options Array of options for the request
     * @param string $result_class class name of the wanted result
     * @return Generator|$result_class
     * @throws \Exception
     */
    private function searchItem($item, $query, array $options, $result_class)
    {
        try
        {
            $query = trim($query);
            if (empty($query))
            {
                throw new \Exception('query parameter can not be empty');
            }
            $params   = $this->_tmdb->checkOptions($options);
            $response = $this->_tmdb->sendRequest('search/'.$item, $query, $params);

            $this->page          = (int) $response->page;
            $this->total_pages   = (int) $response->total_pages;
            $this->total_results = (int) $response->total_results;

            foreach ($response->results as $result)
            {
                $element = new $result_class($result);

                yield $element;
            }
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
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
            $this->searchItem('movie', $query, $options, 'SearchMovieResult');
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
     * @throws \Exception
     */
    public function searchTVShow($query, array $options = array())
    {
        try
        {
            $this->searchItem('tv', $query, $options, 'SearchTVShowResult');
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Search a collection
     * @param string $query Query string to search like a collection
     * @param array $options Array of option for the request
     * @return Generator|SearchCollectionResult
     * @throws \Exception
     */
    public function searchCollection($query, array $options = array())
    {
        try
        {
            $this->searchItem('collection', $query, $options, 'SearchCollectionResult');
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

    /**
     * Get page from result search
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get total page from result search
     * @return int
     */
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    /**
     * Get total results from search
     * @return int
     */
    public function getTotalResults()
    {
        return $this->total_results;
    }

}