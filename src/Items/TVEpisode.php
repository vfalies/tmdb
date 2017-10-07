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
use vfalies\tmdb\Interfaces\Items\TVEpisodeInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Results;
use vfalies\tmdb\Traits\TVEpisodeTrait;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * TVEpisode class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class TVEpisode extends Item implements TVEpisodeInterface
{
    use ElementTrait;
    use TVEpisodeTrait;

    /**
     * Season number
     * @var int
     */
    protected $season_number;
    /**
     * Episode number
     * @var int
     */
    protected $episode_number;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $tv_id
     * @param int $season_number
     * @param int $episode_number
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, $tv_id, $season_number, $episode_number, array $options = array())
    {
        parent::__construct($tmdb, $episode_number, $options, 'tv/' . $tv_id . '/' . $season_number);

        $this->season_number = $season_number;
        $this->episode_number = $episode_number;
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId()
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
    public function getAirDate()
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
    public function getEpisodeNumber()
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
    public function getGuestStars()
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
    public function getName()
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
    public function getNote()
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
    public function getNoteCount()
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
    public function getOverview()
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
    public function getProductionCode()
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
    public function getSeasonNumber()
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
    public function getStillPath()
    {
        if (isset($this->data->still_path)) {
            return $this->data->still_path;
        }
        return '';
    }

    /**
     * Image posters
     * @return \Generator|Results\Image
     */
    public function getPosters()
    {
        $data = $this->tmdb->getRequest('/tv/' . (int) $this->id . '/seasons/' . $this->season_number . '/episode/' . $this->episode_number . '/images', $this->params);

        foreach ($data->posters as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }
}
