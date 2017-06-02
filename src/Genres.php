<?php

namespace Vfac\Tmdb;

class Genres implements Interfaces\GenresInterface
{

    protected $tmdb = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     * @throws Exception
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
        } catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get TV genres list
     * @param array $options
     * @return \Generator
     * @throws \Exception
     */
    public function getTVList(array $options = array()): \Generator
    {
        try
        {
            return $this->getList('genre/tv/list', $options);
        } catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Generic getter list
     * @param string $type
     * @param array $options
     * @return \Generator
     * @throws \Exception
     */
    private function getList(string $type, array $options): \Generator
    {
        try
        {
            $params   = $this->tmdb->checkOptions($options);
            $response = $this->tmdb->sendRequest(new CurlRequest(), $type, null, $params);

            $genres = [];
            if (isset($response->genres))
            {
                $genres = $response->genres;
            }

            return $this->genreItemGenerator($genres);
        } catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
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
