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


namespace vfalies\tmdb\Interfaces\Results;

/**
 * Interface for People Results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface PeopleResultsInterface extends ResultsInterface
{
    /**
     * Profile path
     */
    public function getProfilePath();

    /**
     * Adult
     */
    public function getAdult();

    /**
     * People name
     */
    public function getName();

    /**
     * People popularity
     */
    public function getPopularity();
}
