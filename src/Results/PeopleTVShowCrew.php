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
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a people tvshow crew result
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class PeopleTVShowCrew extends Results
{

    /**
     * Credit Id
     * @var string
     */
    protected $credit_id = null;

    /**
     * name
     * @var string
     */
    protected $name = null;

    /**
     * Image poster path
     * @var string
     */
    protected $poster_path = null;

    /**
     * original name
     * @var string
     */
    protected $original_name = null;

    /**
     * First air date
     * @var string
     */
    protected $first_air_date = null;

    /**
     * Id
     * @var int
     */
    protected $id = null;

    /**
     * Department
     * @var string
     */
    protected $department = null;

    /**
     * Job
     * @var string
     */
    protected $job = null;

    /**
     * Episode count
     * @var int
     */
    protected $episode_count = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id             = $this->data->id;
        $this->episode_count  = $this->data->episode_count;
        $this->department     = $this->data->department;
        $this->job            = $this->data->job;
        $this->credit_id      = $this->data->credit_id;
        $this->original_name  = $this->data->original_name;
        $this->name           = $this->data->name;
        $this->poster_path    = $this->data->poster_path;
        $this->first_air_date = $this->data->first_air_date;
    }

    /**
     * Get Id
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Get credit Id
     * @return string
     */
    public function getCreditId()
    {
        return $this->credit_id;
    }

    /**
     * Get department name
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Get job
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get original ,name
     * @return string
     */
    public function getOriginalName()
    {
        return $this->original_name;
    }

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath()
    {
        return $this->poster_path;
    }

    /**
     * Get first air date
     * @return string
     */
    public function getFirstAirDate()
    {
        return $this->first_air_date;
    }

    /**
     * Episode count
     * @return int
     */
    public function getEpisodeCount()
    {
        return $this->episode_count;
    }

}
