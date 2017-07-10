<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\MovieInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotYetImplementedException;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Items\Credit;
use vfalies\tmdb\Items\Cast;

class Movie extends Item implements MovieInterface
{
    use ElementTrait;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $movie_id, array $options = array())
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
        $credit = new Credit($this->tmdb, $this->id);
        return $credit->getCrew();
    }

    /**
     * Get movie cast
     * @return \Generator|Results\Cast
     */
    public function getCast()
    {
        $cast = new Credit($this->tmdb, $this->id);
        return $cast->getCast();
    }

    public function getProductionCompanies()
    {
        if ( ! empty($this->data->production_companies))
        {
            foreach ($this->data->production_companies as $p)
            {
                $res       = new \stdClass();
                $res->id   = $p->id;
                $res->name = $p->name;

                yield $res;
            }
        }
    }

    public function getProductionCountries()
    {
        if ( ! empty($this->data->production_countries))
        {
            foreach ($this->data->production_countries as $c)
            {
                $res             = new \stdClass();
                $res->iso_3166_1 = $c->iso_3166_1;
                $res->name       = $c->name;

                yield $res;
            }
        }
    }
}
