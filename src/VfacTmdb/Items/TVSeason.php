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
 * @copyright Copyright (c) 2017-2021
 */


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Items\TVItem;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\Items\TVSeasonInterface;
use VfacTmdb\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * TVSeason class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2021
 */
class TVSeason extends TVItem implements TVSeasonInterface
{

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
        $this->tv_id         = $tv_id;

        $this->setElementTrait($this->data);
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
     * Get the underlying ItemChanges object for this Item
     * @param array $options Array of options for the request
     * @return TVSeasonItemChanges
     */
    public function getItemChanges(array $options = array()) : TVSeasonItemChanges
    {
        return new TVSeasonItemChanges($this->tmdb, $this->getId(), $options);
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


    /**
     * Get TVShow Season crew
     * @return \Generator|Results\Crew
     */
    public function getCrew() : \Generator
    {
        $credit = new TVSeasonCredit($this->tmdb, $this->tv_id, $this->season_number);
        return $credit->getCrew();
    }

    /**
     * Get TVShow Season cast
     * @return \Generator|Results\Cast
     */
    public function getCast() : \Generator
    {
        $cast = new TVSeasonCredit($this->tmdb, $this->tv_id, $this->season_number);
        return $cast->getCast();
    }
}
