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
use VfacTmdb\Interfaces\Results\CrewResultsInterface;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a crew result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Crew extends Results implements CrewResultsInterface
{
    /**
     * Department
     * @var string
     */
    protected $department = null;
    /**
     * Gender
     * @var string
     */
    protected $gender = null;
    /**
     * Credit id
     * @var string
     */
    protected $credit_id = null;
    /**
     * Job
     * @var string
     */
    protected $job = null;
    /**
     * Name
     * @var string
     */
    protected $name = null;
    /**
     * Image profile path
     * @var string
     */
    protected $profile_path = null;
    /**
     * Id
     * @var int
     */
    protected $id = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
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
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Credit Id
     * @return string
     */
    public function getCreditId() : string
    {
        return $this->credit_id;
    }

    /**
     * Department
     * @return string
     */
    public function getDepartment() : string
    {
        return $this->department;
    }

    /**
     * Gender
     * @return string|null
     */
    public function getGender() : ?string
    {
        return $this->gender;
    }

    /**
     * Job
     * @return string
     */
    public function getJob() : string
    {
        return $this->job;
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
     * Image profile path
     * @return string
     */
    public function getProfilePath() : string
    {
        return $this->profile_path;
    }
}
