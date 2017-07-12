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


namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVShowInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Results\Image;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * TVShow class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class TVShow extends Item implements TVShowInterface
{

    use ElementTrait;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param int $tv_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, $tv_id, array $options = array())
    {
        parent::__construct($tmdb, $tv_id, $options, 'tv');
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get TVSHow genres
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
     * Get TVshow note
     *  @return float
     */
    public function getNote()
    {
        if (isset($this->data->vote_average)) {
            return $this->data->vote_average;
        }
        return 0;
    }

    /**
     * Get TVshow number of episodes
     * @return int
     */
    public function getNumberEpisodes()
    {
        if (isset($this->data->number_of_episodes)) {
            return $this->data->number_of_episodes;
        }
        return 0;
    }

    /**
     * Get TVShow number of seasons
     * @return int
     */
    public function getNumberSeasons()
    {
        if (isset($this->data->number_of_seasons)) {
            return $this->data->number_of_seasons;
        }
        return 0;
    }

    /**
     * Get TVShow original title
     * @return string
     */
    public function getOriginalTitle()
    {
        if (isset($this->data->original_name)) {
            return $this->data->original_name;
        }
        return '';
    }

    /**
     * Get TVShow overview
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
     * Get TVShow release date
     * @return string
     */
    public function getReleaseDate()
    {
        if (isset($this->data->first_air_date)) {
            return $this->data->first_air_date;
        }
        return '';
    }

    /**
     * Get TVShow status
     * @return string
     */
    public function getStatus()
    {
        if (isset($this->data->status)) {
            return $this->data->status;
        }
        return '';
    }

    /**
     * Get TVShow title
     * @return string
     */
    public function getTitle()
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Get TVShow seasons
     * @return \Generator|Results\TVSeason
     */
    public function getSeasons()
    {
        if (!empty($this->data->seasons)) {
            foreach ($this->data->seasons as $season) {
                $season = new \vfalies\tmdb\Results\TVSeason($this->tmdb, $season);
                yield $season;
            }
        }
    }

    /**
     * Backdrops list
     * @return \Generator|Results\Image
     */
    public function getBackdrops()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/tv/'.(int) $this->id.'/images', null, $this->params);

        foreach ($data->backdrops as $b)
        {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Posters list
     * @return \Generator|Results\Image
     */
    public function getPosters()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/tv/'.(int) $this->id.'/images', null, $this->params);

        foreach ($data->posters as $b)
        {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }
}
