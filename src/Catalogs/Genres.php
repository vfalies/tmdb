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


namespace vfalies\tmdb\Catalogs;

use vfalies\tmdb\Interfaces\GenresInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to get movie and tv show genres
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Genres implements GenresInterface
{

    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Get movie genres list
     * @param array $options
     * @return \Generator
     * @throws \Exception
     */
    public function getMovieList(array $options = array())
    {
        try {
            return $this->getList('genre/movie/list', $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Get TV genres list
     * @param array $options
     * @return \Generator
     * @throws TmdbException
     */
    public function getTVList(array $options = array())
    {
        try {
            return $this->getList('genre/tv/list', $options);
        } catch (TmdbException $ex) {
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
    private function getList($type, array $options)
    {
        try {
            $params   = $this->tmdb->checkOptions($options);
            $response = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), $type, null, $params);

            $genres = [];
            if (isset($response->genres)) {
                $genres = $response->genres;
            }

            return $this->genreItemGenerator($genres);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Genre Item generator method
     * @param array $results
     */
    private function genreItemGenerator(array $results)
    {
        foreach ($results as $result) {
            yield $result;
        }
    }
}
