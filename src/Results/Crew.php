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
use vfalies\tmdb\Interfaces\Results\CrewResultsInterface;
use vfalies\tmdb\Tmdb;

/**
 * Class to manipulate a crew result
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Crew extends Results implements CrewResultsInterface
{
    /**
     * Department
     * @var string
     */
    protected $department   = null;
    /**
     * Gender
     * @var string
     */
    protected $gender       = null;
    /**
     * Credit id
     * @var string
     */
    protected $credit_id    = null;
    /**
     * Job
     * @var string
     */
    protected $job          = null;
    /**
     * Name
     * @var string
     */
    protected $name         = null;
    /**
     * Image profile path
     * @var string
     */
    protected $profile_path = null;
    /**
     * Id
     * @var int
     */
    protected $id           = null;

    /**
     * Constructor
     * @param Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id           = $this->data->id;
        $this->department   = $this->data->department;
        $this->gender       = $this->data->gender;
        $this->credit_id    = $this->data->credit_id;
        $this->job          = $this->data->job;
        $this->name         = $this->data->name;
        $this->profile_path = $this->data->profile_path;
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
     * Credit Id
     * @return string
     */
    public function getCreditId()
    {
        return $this->credit_id;
    }

    /**
     * Department
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Gender
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Job
     * @return string
     */
    public function getJob()
    {
        return $this->job;
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
     * Image profile path
     * @return string
     */
    public function getProfilePath()
    {
        return $this->profile_path;
    }

}
