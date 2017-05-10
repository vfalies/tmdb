<?php

namespace Vfac\Tmdb;

class Search
{

    private $_tmdb = null;
    private $_conf = null;

    public function __construct(Tmdb $tmdb)
    {
        $this->_tmdb = $tmdb;
        $this->_conf = $this->_tmdb->getConfiguration();
    }

    /**
     * Search a movie
     * @param string $query Query string to search like a movie
     * @param array $options Array of options for the search
     * @return Generator
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
                $movie                 = new \stdClass();
                $movie->id             = $result->id;
                $movie->overview       = $result->overview;
                $movie->release_date   = $result->release_date;
                $movie->original_title = $result->original_title;
                $movie->title          = $result->title;
                $movie->poster         = $result->original_title;
                $movie->backdrop       = $result->backdrop_path;

                yield $movie;
            }
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function getMovie($movie_id, array $options = array())
    {
        $movie = new Movie($this->_tmdb, $movie_id, $options);

        return $movie;
    }

    public function getCollection($collection_id, array $options = array())
    {
        $collection = new Collection($this->_tmdb, $collection_id, $options);

        return $collection;
    }

    public function getTVShow($tv_id, array $options = array())
    {
        $tv = new TVShow($this->_tmdb, $tv_id, $options);

        return $tv;
    }
}
