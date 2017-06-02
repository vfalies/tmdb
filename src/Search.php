<?php

namespace vfalies\tmdb;

class Search
{

    private $tmdb          = null;
    private $page          = 1; // Page number of the search result
    private $total_pages   = 1; // Total pages of the search result
    private $total_results = 0; // Total results of the search result

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     */

    public function __construct(Tmdb $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Search specify item
     * @param string $item item to search : movie / tv / collection
     * @param string $query Query string to search like a $item
     * @param array $options Array of options for the request
     * @param string $result_class class name of the wanted result
     * @return \Generator
     * @throws \Exception
     */
    private function searchItem(string $item, string $query, array $options, $result_class): \Generator
    {
        try
        {
            $query = trim($query);
            if (empty($query))
            {
                throw new \Exception('query parameter can not be empty');
            }
            $params   = $this->tmdb->checkOptions($options);
            $response = $this->tmdb->sendRequest(new CurlRequest(), 'search/'.$item, $query, $params);

            $this->page          = (int) $response->page;
            $this->total_pages   = (int) $response->total_pages;
            $this->total_results = (int) $response->total_results;

            return $this->searchItemGenerator($response->results, $result_class);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Search Item generator method
     * @param array $results
     * @param string $class
     */
    private function searchItemGenerator(array $results, string $class): \Generator
    {
        foreach ($results as $result)
        {
            $element = new $class($this->tmdb, $result);

            yield $element;
        }
    }

    /**
     * Search a movie
     * @param string $query Query string to search like a movie
     * @param array $options Array of options for the search
     * @return \Generator|Results\Movie
     * @throws \Exception
     */
    public function searchMovie(string $query, array $options = array()): \Generator
    {
        try
        {
            return $this->searchItem('movie', $query, $options, __NAMESPACE__."\\Results\\".'Movie');
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
     * @return \Generator|Results\TVShow
     * @throws \Exception
     */
    public function searchTVShow(string $query, array $options = array()): \Generator
    {
        try
        {
            return $this->searchItem('tv', $query, $options, __NAMESPACE__."\\Results\\".'TVShow');
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
     * @return \Generator|Results\Collection
     * @throws \Exception
     */
    public function searchCollection(string $query, array $options = array()): \Generator
    {
        try
        {
            return $this->searchItem('collection', $query, $options, __NAMESPACE__."\\Results\\".'Collection');
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

    /**
     * Get page from result search
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get total page from result search
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->total_pages;
    }

    /**
     * Get total results from search
     * @return int
     */
    public function getTotalResults(): int
    {
        return $this->total_results;
    }

}
