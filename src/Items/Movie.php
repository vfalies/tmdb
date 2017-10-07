<?php
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


namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\MovieInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Items\MovieCredit;

use vfalies\tmdb\Results\Image;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Results\Movie as ResultMovie;

/**
 * Movie class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Movie extends Item implements MovieInterface
{
    use ElementTrait;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, $movie_id, array $options = array())
    {
        parent::__construct($tmdb, $movie_id, $options, 'movie');
    }

    /**
     * Get movie genres
     * @return array
     */
    public function getGenres()
    {
        if (isset($this->data->genres)) {
            return $this->data->genres;
        }
        return [];
    }

    /**
     * Get movie title
     * @return string
     */
    public function getTitle()
    {
        if (isset($this->data->title)) {
            return $this->data->title;
        }
        return '';
    }

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview()
    {
        if (isset($this->data->overview)) {
            return $this->data->overview;
        }
        return '';
    }

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate()
    {
        if (isset($this->data->release_date)) {
            return $this->data->release_date;
        }
        return '';
    }

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle()
    {
        if (isset($this->data->original_title)) {
            return $this->data->original_title;
        }
        return '';
    }

    /**
     * Get movie note
     * @return float
     */
    public function getNote()
    {
        if (isset($this->data->vote_average)) {
            return $this->data->vote_average;
        }
        return 0;
    }

    /**
     * Get movie id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get IMDB movie id
     * @return string
     */
    public function getIMDBId()
    {
        if (isset($this->data->imdb_id)) {
            return $this->data->imdb_id;
        }
        return '';
    }

    /**
     * Get movie tagline
     * @return string
     */
    public function getTagLine()
    {
        if (isset($this->data->tagline)) {
            return $this->data->tagline;
        }
        return '';
    }

    /**
     * Get collection id
     * @return int
     */
    public function getCollectionId()
    {
        if (!empty($this->data->belongs_to_collection)) {
            return (int) $this->data->belongs_to_collection->id;
        }
        return 0;
    }

    /**
     * Get movie crew
     * @return \Generator|Results\Crew
     */
    public function getCrew()
    {
        $credit = new MovieCredit($this->tmdb, $this->id);
        return $credit->getCrew();
    }

    /**
     * Get movie cast
     * @return \Generator|Results\Cast
     */
    public function getCast()
    {
        $cast = new MovieCredit($this->tmdb, $this->id);
        return $cast->getCast();
    }

    /**
     * Get production compagnies
     * @return \Generator|stdClass
     */
    public function getProductionCompanies()
    {
        if (!empty($this->data->production_companies)) {
            foreach ($this->data->production_companies as $p) {
                $res       = new \stdClass();
                $res->id   = $p->id;
                $res->name = $p->name;

                yield $res;
            }
        }
    }

    /**
     * Get production countries
     * @return \Generator|stdClass
     */
    public function getProductionCountries()
    {
        if (!empty($this->data->production_countries)) {
            foreach ($this->data->production_countries as $c) {
                $res             = new \stdClass();
                $res->iso_3166_1 = $c->iso_3166_1;
                $res->name       = $c->name;

                yield $res;
            }
        }
    }

    /**
     * Get image backdrops list
     * @return \Generator|Results\Image
     */
    public function getBackdrops()
    {
        $data = $this->tmdb->getRequest('/movie/' . (int) $this->id . '/images', $this->params);

        foreach ($data->backdrops as $b) {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get image posters list
     * @return \Generator|Results\Image
     */
    public function getPosters()
    {
        $data = $this->tmdb->getRequest('/movie/' . (int) $this->id . '/images', $this->params);

        foreach ($data->posters as $b) {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get similar movies from current movie
     * @return \Generator|Results\Movie
     */
    public function getSimilar()
    {
        $data = $this->tmdb->getRequest('/movie/' . (int) $this->id . '/similar', $this->params);

        foreach ($data->results as $s) {
            $movie = new ResultMovie($this->tmdb, $s);
            yield $movie;
        }
    }
}
