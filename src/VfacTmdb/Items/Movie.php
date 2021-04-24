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


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Interfaces\Items\MovieInterface;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Items\MovieCredit;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Results;

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
    public function __construct(TmdbInterface $tmdb, int $movie_id, array $options = array())
    {
        parent::__construct($tmdb, $movie_id, $options, 'movie');

        $this->setElementTrait($this->data);
    }

    /**
     * Get movie genres
     * @return array
     */
    public function getGenres() : array
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
    public function getTitle() : string
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
    public function getOverview() : string
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
    public function getReleaseDate() : string
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
    public function getOriginalTitle() : string
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
    public function getNote() : float
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
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get IMDB movie id
     * @return string
     */
    public function getIMDBId() : string
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
    public function getTagLine() : string
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
    public function getCollectionId() : int
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
    public function getCrew() : \Generator
    {
        $credit = new MovieCredit($this->tmdb, $this->id);
        return $credit->getCrew();
    }

    /**
     * Get movie cast
     * @return \Generator|Results\Cast
     */
    public function getCast() : \Generator
    {
        $cast = new MovieCredit($this->tmdb, $this->id);
        return $cast->getCast();
    }

    /**
     * Get movie videos
     *
     * @return \Generator|Results\Videos
     */
    public function getVideos() :\Generator
    {
        $videos = new MovieVideos($this->tmdb, $this->id);
        return $videos->getVideos();
    }

    /**
     * Get production companies
     * @return \Generator|Results\Company
     */
    public function getProductionCompanies() : \Generator
    {
        if (!empty($this->data->production_companies)) {
            foreach ($this->data->production_companies as $p) {
                $res            = new \stdClass();
                $res->id        = $p->id;
                $res->name      = $p->name;
                $res->logo_path = null;

                $company        = new Results\Company($this->tmdb, $res);
                yield $company;
            }
        }
    }

    /**
     * Get production countries
     * @return \Generator|\stdClass
     */
    public function getProductionCountries() : \Generator
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
    public function getBackdrops() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('movie/' . (int) $this->id . '/images', $params);

        foreach ($data->backdrops as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get image posters list
     * @return \Generator|Results\Image
     */
    public function getPosters() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('movie/' . (int) $this->id . '/images', $params);

        foreach ($data->posters as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get similar movies from current movie
     * @return \Generator|Results\Movie
     */
    public function getSimilar() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $this->tmdb->checkOptionPage($this->params, $params);
        $data = $this->tmdb->getRequest('movie/' . (int) $this->id . '/similar', $params);

        foreach ($data->results as $s) {
            $movie = new Results\Movie($this->tmdb, $s);
            yield $movie;
        }
    }

    /**
     * Get the underlying ItemChanges object for this Item
     * @param array $options Array of options for the request
     * @return MovieItemChanges
     */
    public function getItemChanges(array $options = array()) : MovieItemChanges
    {
        return new MovieItemChanges($this->tmdb, $this->id, $options);
    }

    /**
     * Get this Item's Changes
     * @param array $options Array of options for the request
     * @return \Generator
     */
    public function getChanges(array $options = array()) : \Generator
    {
        $changes = $this->getItemChanges($options);
        return $changes->getChanges();
    }
}
