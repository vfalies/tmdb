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


namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Interfaces\Results\TVEpisodeResultsInterface;
use vfalies\tmdb\Exceptions\NotYetImplementedException;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Traits\TVEpisodeTrait;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a TV Episode result
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class TVEpisode extends Results implements TVEpisodeResultsInterface
{

    use ElementTrait;
    use TVEpisodeTrait;

    /**
     * Episode number
     * @var int
     */
    protected $episode_number  = 0;
    /**
     * Name
     * @var string
     */
    protected $name            = '';
    /**
     * Air date
     * @var string
     */
    protected $air_date        = null;
    /**
     * Season number
     * @var int
     */
    protected $season_number   = 0;
    /**
     * Vote average
     * @var float
     */
    protected $vote_average    = 0;
    /**
     * Vote count
     * @var int
     */
    protected $vote_count      = 0;
    /**
     * Overview
     * @var string
     */
    protected $overview        = '';
    /**
     * Production code
     * @var string
     */
    protected $production_code = '';
    /**
     * Image still path
     * @var string
     */
    protected $still_path      = '';
    /**
     * Id
     * @var int
     */
    protected $id              = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
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
    }

    /**
     * Air date
     * @return string
     */
    public function getAirDate()
    {
        return $this->air_date;
    }

    /**
     * Episode number
     * @return int
     */
    public function getEpisodeNumber()
    {
        return (int) $this->episode_number;
    }

    /**
     * Guests stars
     * @codeCoverageIgnore
     * @throws NotYetImplementedException
     */
    public function getGuestStars()
    {
        throw new NotYetImplementedException;
    }

    /**
     * Id
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Note
     * @return float
     */
    public function getNote()
    {
        return $this->vote_average;
    }

    /**
     * Note count
     * @return int
     */
    public function getNoteCount()
    {
        return (int) $this->vote_count;
    }

    /**
     * Overview
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Production code
     * @return string
     */
    public function getProductionCode()
    {
        return $this->production_code;
    }

    /**
     * Season number
     * @return int
     */
    public function getSeasonNumber()
    {
        return (int) $this->season_number;
    }

    /**
     * Image still path
     * @return string
     */
    public function getStillPath()
    {
        return $this->still_path;
    }

}
