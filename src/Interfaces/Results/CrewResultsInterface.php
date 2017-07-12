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


namespace vfalies\tmdb\Interfaces\Results;

/**
 * Interface for Crew results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
interface CrewResultsInterface {

    /**
     * Credit Id
     */
    public function getCreditId();

    /**
     * Department
     */
    public function getDepartment();

    /**
     * Gender
     */
    public function getGender();

    /**
     * Job
     */
    public function getJob();

    /**
     * Name
     */
    public function getName();

    /**
     * Image profile path
     */
    public function getProfilePath();
}