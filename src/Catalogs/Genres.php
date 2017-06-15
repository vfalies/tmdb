<?php

namespace vfalies\tmdb\Catalogs;

use vfalies\tmdb\Interfaces\GenresInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\TmdbException;

class Genres implements GenresInterface
{

    protected $tmdb = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     */
    public function __construct(Tmdb $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Get movie genres list
     * @param array $options
     * @return \Generator
     * @throws \Exception
     */
    public function getMovieList(array $options = array()): \Generator
    {
        try
        {            
            return $this->getList('genre/movie/list', $options);
        } catch (TmdbException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Get TV genres list
     * @param array $options
     * @return \Generator
     * @throws TmdbException
     */
    public function getTVList(array $options = array()): \Generator
    {
        try
        {
            return $this->getList('genre/tv/list', $options);
        } catch (TmdbException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Generic getter list
     * @param string $type
     * @param array $options
     * @return \Generator
     * @throws TmdbException
     */
    private function getList(string $type, array $options): \Generator
    {
        try
        {
            $params   = $this->tmdb->checkOptions($options);
            $response = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), $type, null, $params);

            $genres = [];
            if (isset($response->genres))
            {
                $genres = $response->genres;
            }

            return $this->genreItemGenerator($genres);
        } catch (TmdbException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Genre Item generator method
     * @param array $results
     */
    private function genreItemGenerator(array $results): \Generator
    {
        foreach ($results as $result)
        {
            yield $result;
        }
    }

}
