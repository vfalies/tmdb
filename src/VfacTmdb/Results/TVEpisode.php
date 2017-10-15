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


namespace VfacTmdb\Results;

use VfacTmdb\Abstracts;
use VfacTmdb\Results;
use VfacTmdb\Interfaces\Results\TVEpisodeResultsInterface;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Traits\TVEpisodeTrait;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a TV Episode result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class TVEpisode extends Abstracts\Results implements TVEpisodeResultsInterface
{
    use ElementTrait;
    use TVEpisodeTrait;

    /**
     * Episode number
     * @var int
     */
    protected $episode_number = 0;
    /**
     * Name
     * @var string
     */
    protected $name = '';
    /**
     * Air date
     * @var string
     */
    protected $air_date = null;
    /**
     * Season number
     * @var int
     */
    protected $season_number = 0;
    /**
     * Vote average
     * @var float
     */
    protected $vote_average = 0;
    /**
     * Vote count
     * @var int
     */
    protected $vote_count = 0;
    /**
     * Overview
     * @var string
     */
    protected $overview = '';
    /**
     * Production code
     * @var string
     */
    protected $production_code = '';
    /**
     * Image still path
     * @var string
     */
    protected $still_path = '';
    /**
     * Id
     * @var int
     */
    protected $id = null;
    /**
     * Guest stars
     * @var array
     */
    protected $guest_stars = [];

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        $result = $this->initResultObject($result);

        parent::__construct($tmdb, $result);

        // Populate data
        $this->id              = $this->data->id;
        $this->air_date        = $this->data->air_date;
        $this->season_number   = $this->data->season_number;
        $this->episode_number  = $this->data->episode_number;
        $this->name            = $this->data->name;
        $this->vote_average    = $this->data->vote_average;
        $this->vote_count      = $this->data->vote_count;
        $this->overview        = $this->data->overview;
        $this->production_code = $this->data->production_code;
        $this->still_path      = $this->data->still_path;
        $this->guest_stars     = $this->data->guest_stars;

        $this->setElementTrait($this->data);
        $this->setTVEpisodeTrait($tmdb, $this->data);
    }

    /**
     * initResultObject
     * @param  \stdClass  $result
     * @return \stdClass
     */
    private function initResultObject(\stdClass $result) : \stdClass
    {
        if (!isset($result->overview)) {
            $result->overview = null;
        }
        if (!isset($result->production_code)) {
            $result->production_code = null;
        }
        if (!isset($result->guest_stars)) {
            $result->guest_stars = null;
        }
        return $result;
    }

    /**
     * Air date
     * @return string
     */
    public function getAirDate() : string
    {
        return $this->air_date;
    }

    /**
     * Episode number
     * @return int
     */
    public function getEpisodeNumber() : int
    {
        return (int) $this->episode_number;
    }

    /**
     * Guests stars
     * @return \Generator|Results\Cast
     */
    public function getGuestStars() : \Generator
    {
        if (isset($this->guest_stars)) {
            foreach ($this->guest_stars as $gs) {
                $gs->gender = null;
                $gs->cast_id = null;

                $star = new Results\Cast($this->tmdb, $gs);
                yield $star;
            }
        }
    }

    /**
     * Id
     * @return int
     */
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Note
     * @return float
     */
    public function getNote() : float
    {
        return $this->vote_average;
    }

    /**
     * Note count
     * @return int
     */
    public function getNoteCount() : int
    {
        return (int) $this->vote_count;
    }

    /**
     * Overview
     * @return string
     */
    public function getOverview() : string
    {
        return $this->overview;
    }

    /**
     * Production code
     * @return string
     */
    public function getProductionCode() : string
    {
        return $this->production_code;
    }

    /**
     * Season number
     * @return int
     */
    public function getSeasonNumber() : int
    {
        return (int) $this->season_number;
    }

    /**
     * Image still path
     * @return string
     */
    public function getStillPath() : string
    {
        return $this->still_path;
    }
}
