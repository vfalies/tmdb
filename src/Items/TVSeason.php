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
use vfalies\tmdb\Interfaces\Items\TVSeasonInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Results\Image;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * TVSeason class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class TVSeason extends Item implements TVSeasonInterface
{

    use ElementTrait;

    /**
     * Season number
     * @var int
     */
    protected $season_number;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param int $tv_id
     * @param int $season_number
     * @param array $options
     * @throws Exception
     */
    public function __construct(TmdbInterface $tmdb, $tv_id, $season_number, array $options = array())
    {
        parent::__construct($tmdb, $season_number, $options, 'tv/'.$tv_id);

        $this->season_number = $season_number;
    }

    /**
     * Id
     * @return int
     */
    public function getId()
    {
        if ( ! empty($this->data->id))
        {
            return (int) $this->data->id;
        }
        return 0;
    }

    /**
     * Air date
     * @return string
     */
    public function getAirDate()
    {
        if ( ! empty($this->data->air_date))
        {
            return $this->data->air_date;
        }
        return '';
    }

    /**
     * Episode count
     * @return int
     */
    public function getEpisodeCount()
    {
        if ( ! empty($this->data->episodes))
        {
            return count($this->data->episodes);
        }
        return 0;
    }

    /**
     * Season number
     * @return int
     */
    public function getSeasonNumber()
    {
        if ( ! empty($this->data->season_number))
        {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    /**
     * Episodes list
     * @return \Generator|Results\TVEpisode
     */
    public function getEpisodes()
    {
        if ( ! empty($this->data->episodes))
        {
            foreach ($this->data->episodes as $episode)
            {
                $episode = new \vfalies\tmdb\Results\TVEpisode($this->tmdb, $episode);
                yield $episode;
            }
        }
    }

    /**
     * Name
     * @return string
     */
    public function getName()
    {
        if ( ! empty($this->data->name))
        {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Overview
     * @return string
     */
    public function getOverview()
    {
        if ( ! empty($this->data->overview))
        {
            return $this->data->overview;
        }
        return '';
    }

    /**
     * Posters list
     * @return \Generator|Results\Image
     */
    public function getPosters()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/tv/'.(int) $this->id.'/seasons/'.$this->season_number.'/images', null, $this->params);

        foreach ($data->posters as $b)
        {
            $image = new Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

}
