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

use VfacTmdb\Abstracts\Items\TVItem;
use VfacTmdb\Interfaces\Items\TVEpisodeInterface;
use VfacTmdb\Results;
use VfacTmdb\Traits\TVEpisodeTrait;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * TVEpisode class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class TVEpisode extends TVItem implements TVEpisodeInterface
{
    use TVEpisodeTrait;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $tv_id
     * @param int $season_number
     * @param int $episode_number
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $tv_id, int $season_number, int $episode_number, array $options = array())
    {
        parent::__construct($tmdb, $episode_number, $options, 'tv/' . $tv_id . '/season/' . $season_number . '/episode');

        $this->season_number  = $season_number;
        $this->episode_number = $episode_number;
        $this->tv_id          = $tv_id;

        $this->setElementTrait($this->data);
        $this->setTVEpisodeTrait($tmdb, $this->data);
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId(): int
    {
        if (isset($this->data->id)) {
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
        if (isset($this->data->air_date)) {
            return $this->data->air_date;
        }
        return '';
    }

    /**
     * Episode number
     * @return int
     */
    public function getEpisodeNumber() : int
    {
        if (isset($this->data->episode_number)) {
            return $this->data->episode_number;
        }
        return 0;
    }

    /**
     * Guests stars
     * @return \Generator|Results\Cast
     */
    public function getGuestStars() : \Generator
    {
        if (isset($this->data->guest_stars)) {
            foreach ($this->data->guest_stars as $gs) {
                $gs->gender = null;
                $gs->cast_id = null;

                $star = new Results\Cast($this->tmdb, $gs);
                yield $star;
            }
        }
    }

    /**
     * Name
     * @return string
     */
    public function getName() : string
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Note
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
     * Note count
     * @return int
     */
    public function getNoteCount() : int
    {
        if (isset($this->data->vote_count)) {
            return (int) $this->data->vote_count;
        }
        return 0;
    }

    /**
     * Overview
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
     * Production code
     * @return string
     */
    public function getProductionCode() : string
    {
        if (isset($this->data->production_code)) {
            return $this->data->production_code;
        }
        return '';
    }

    /**
     * Season number
     * @return int
     */
    public function getSeasonNumber() : int
    {
        if (isset($this->data->season_number)) {
            return (int) $this->data->season_number;
        }
        return 0;
    }

    /**
     * Image still path
     * @return string
     */
    public function getStillPath() : string
    {
        if (isset($this->data->still_path)) {
            return $this->data->still_path;
        }
        return '';
    }
}
