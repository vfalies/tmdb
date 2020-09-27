<?php declare(strict_types=1);
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */


namespace VfacTmdb\Catalogs;

use VfacTmdb\Interfaces\GenresInterface;

use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to get movie and tv show genres
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
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
     * @param TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Get movie genres list
     * @param array $options
     * @return \Generator
     * @throws TmdbException
     */
    public function getMovieList(array $options = array()) : \Generator
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
    public function getTVList(array $options = array()) : \Generator
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
    private function getList(string $type, array $options) : \Generator
    {
        try {
            $params = [];
            $this->tmdb->checkOptionLanguage($options, $params);
            $response = $this->tmdb->getRequest($type, $params);

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
     * @return \Generator
     */
    private function genreItemGenerator(array $results) : \Generator
    {
        foreach ($results as $result) {
            yield $result;
        }
    }
}
