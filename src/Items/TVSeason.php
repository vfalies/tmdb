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


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\Items\TVSeasonInterface;
use VfacTmdb\Traits\ElementTrait;

use VfacTmdb\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * TVSeason class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
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
     * @param TmdbInterface $tmdb
     * @param int $tv_id
     * @param int $season_number
     * @param array $options
     * @throws TmdbException
     */
    public function __construct(TmdbInterface $tmdb, int $tv_id, int $season_number, array $options = array())
    {
        parent::__construct($tmdb, $season_number, $options, 'tv/' . $tv_id . '/season');

        $this->season_number = $season_number;
    }

    /**
     * Id
     * @return int
     */
    public function getId() : int
    {
        if (!empty($this->data->id)) {
            return (int) $this->data->id;
        }
        return 0;
    }

    /**
     * Air date
     * @return string
     */
    public function getAirDate() : string
    {
        if (!empty($this->data->air_date)) {
            return $this->data->air_date;
        }
        return '';
    }

    /**
     * Episode count
     * @return int
     */
    public function getEpisodeCount() : int
    {
        if (!empty($this->data->episodes)) {
            return count($this->data->episodes);
        }
        return 0;
    }

    /**
     * Season number
     * @return int
     */
    public function getSeasonNumber() : int
    {
        if (!empty($this->data->season_number)) {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    /**
     * Episodes list
     * @return \Generator|Results\TVEpisode
     */
    public function getEpisodes() : \Generator
    {
        if (!empty($this->data->episodes)) {
            foreach ($this->data->episodes as $episode) {
                $episode = new Results\TVEpisode($this->tmdb, $episode);
                yield $episode;
            }
        }
    }

    /**
     * Name
     * @return string
     */
    public function getName() : string
    {
        if (!empty($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Overview
     * @return string
     */
    public function getOverview() : string
    {
        if (!empty($this->data->overview)) {
            return $this->data->overview;
        }
        return '';
    }

    /**
     * Posters list
     * @return \Generator|Results\Image
     */
    public function getPosters() : \Generator
    {
        $data = $this->tmdb->getRequest('/tv/' . (int) $this->id . '/seasons/' . $this->season_number . '/images', $this->params);

        foreach ($data->posters as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }
}
