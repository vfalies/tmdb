<?php

namespace Vfac\Tmdb;

class Movie implements Interfaces\MovieInterface
{

    private $tmdb   = null;
    private $conf   = null;
    private $data   = null;
    private $id     = null;

    /**
     * Constructor
     * @param \Vfac\Tmdb\Tmdb $tmdb
     * @param int $movie_id
     * @param array $options
     * @throws Exception
     */
    public function __construct(Tmdb $tmdb, int $movie_id, array $options = array())
    {
        try
        {
            $this->id   = (int) $movie_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();

            // Get movie details
            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest(new CurlRequest(), 'movie/' . $movie_id, null, $params);
        } catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get movie genres
     * @return array
     */
    public function getGenres(): array
    {
        if (isset($this->data->genres))
        {
            return $this->data->genres;
        }
        return [];
    }

    /**
     * Get movie title
     * @return string
     */
    public function getTitle(): string
    {
        if (isset($this->data->title))
        {
            return $this->data->title;
        }
        return '';
    }

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview(): string
    {
        if (isset($this->data->overview))
        {
            return $this->data->overview;
        }
        return '';
    }

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate(): string
    {
        if (isset($this->data->release_date))
        {
            return $this->data->release_date;
        }
        return '';
    }

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle(): string
    {
        if (isset($this->data->original_title))
        {
            return $this->data->original_title;
        }
        return '';
    }

    /**
     * Get movie note
     * @return float
     */
    public function getNote(): float
    {
        if (isset($this->data->vote_average))
        {
            return $this->data->vote_average;
        }
        return 0;
    }

    /**
     * Get movie id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get IMDB movie id
     * @return string
     */
    public function getIMDBId(): string
    {
        if (isset($this->data->imdb_id))
        {
            return $this->data->imdb_id;
        }
        return '';
    }

    /**
     * Get movie tagline
     * @return string
     */
    public function getTagLine(): string
    {
        if (isset($this->data->tagline))
        {
            return $this->data->tagline;
        }
        return '';
    }

    /**
     * Get collection id
     * @return int
     */
    public function getCollectionId(): int
    {
        if (!empty($this->data->belongs_to_collection))
        {
            return (int) $this->data->belongs_to_collection->id;
        }
        return 0;
    }

    /**
     * Get movie poster
     * @param string $size
     * @return string
     */
    public function getPoster(string $size = 'w185'): string
    {
        if (isset($this->data->poster_path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if (!in_array($size, $this->conf->images->poster_sizes))
            {
                throw new \Exception('Incorrect poster size : ' . $size);
            }
            return $this->conf->images->base_url . $size . $this->data->poster_path;
        }
        return '';
    }

    /**
     * Get movie backdrop
     * @param string $size
     * @return string|null
     */
    public function getBackdrop(string $size = 'w780'): string
    {
        if (isset($this->data->backdrop_path))
        {
            if (!isset($this->conf->images->base_url))
            {
                throw new \Exception('base_url configuration not found');
            }
            if (!in_array($size, $this->conf->images->backdrop_sizes))
            {
                throw new \Exception('Incorrect backdrop size : ' . $size);
            }
            return $this->conf->images->base_url . $size . $this->data->backdrop_path;
        }
        return '';
    }

}
