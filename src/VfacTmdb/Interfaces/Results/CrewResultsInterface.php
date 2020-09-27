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


namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for Crew results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface CrewResultsInterface
{

    /**
     * Credit Id
     * @return string
     */
    public function getCreditId() : string;

    /**
     * Department
     * @return string
     */
    public function getDepartment() : string;

    /**
     * Gender
     * @return string|null
     */
    public function getGender() : ?string;

    /**
     * Job
     * @return string
     */
    public function getJob() : string;

    /**
     * Name
     * @return string
     */
    public function getName() : string;

    /**
     * Image profile path
     * @return string
     */
    public function getProfilePath() : string;
}
