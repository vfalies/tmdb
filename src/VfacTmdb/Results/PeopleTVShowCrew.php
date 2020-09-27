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

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a people tvshow crew result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
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
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        if (!isset($result->episode_count)) {
            $result->episode_count = null;
        }
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
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Get credit Id
     * @return string
     */
    public function getCreditId() : string
    {
        return $this->credit_id;
    }

    /**
     * Get department name
     * @return string
     */
    public function getDepartment() : string
    {
        return $this->department;
    }

    /**
     * Get job
     * @return string
     */
    public function getJob() : string
    {
        return $this->job;
    }

    /**
     * Get name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get original name
     * @return string
     */
    public function getOriginalName() : string
    {
        return $this->original_name;
    }

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath() : string
    {
        return $this->poster_path;
    }

    /**
     * Get first air date
     * @return string
     */
    public function getFirstAirDate() : string
    {
        return $this->first_air_date;
    }

    /**
     * Episode count
     * @return int
     */
    public function getEpisodeCount() : int
    {
        return $this->episode_count;
    }
}
