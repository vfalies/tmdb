<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\TVSeasonInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Results\TVEpisode;
use vfalies\tmdb\Results\Image;

class TVSeason extends Item implements TVSeasonInterface
{

    use ElementTrait;

    protected $season_number;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $tv_id
     * @param int $season_number
     * @param array $options
     * @throws Exception
     */
    public function __construct(Tmdb $tmdb, $tv_id, $season_number, array $options = array())
    {
        parent::__construct($tmdb, $season_number, $options, 'tv/'.$tv_id);

        $this->season_number = $season_number;
    }

    public function getId()
    {
        if ( ! empty($this->data->id))
        {
            return (int) $this->data->id;
        }
        return 0;
    }

    public function getAirDate()
    {
        if ( ! empty($this->data->air_date))
        {
            return $this->data->air_date;
        }
        return '';
    }

    public function getEpisodeCount()
    {
        if ( ! empty($this->data->episodes))
        {
            return count($this->data->episodes);
        }
        return 0;
    }

    public function getSeasonNumber()
    {
        if ( ! empty($this->data->season_number))
        {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    public function getEpisodes()
    {
        if ( ! empty($this->data->episodes))
        {
            foreach ($this->data->episodes as $episode)
            {
                $episode = new TVEpisode($this->tmdb, $episode);
                yield $episode;
            }
        }
    }

    public function getName()
    {
        if ( ! empty($this->data->name))
        {
            return $this->data->name;
        }
        return '';
    }

    public function getOverview()
    {
        if ( ! empty($this->data->overview))
        {
            return $this->data->overview;
        }
        return '';
    }

    public function getPosters()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/tv/'.(int) $this->id.'/seasons/'.$this->season_number.'/images', null, $this->params);

        foreach ($data->posters as $b)
        {
            $image = new Image($this->tmdb, $b);
            yield $image;
        }
    }

}
