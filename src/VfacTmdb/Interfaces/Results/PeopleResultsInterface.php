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
 * Interface for People Results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface PeopleResultsInterface extends ResultsInterface
{
    /**
     * Profile path
     * @return string
     */
    public function getProfilePath() : string;

    /**
     * Adult
     * @return bool
     */
    public function getAdult() : bool;

    /**
     * People name
     * @return string
     */
    public function getName() : string;

    /**
     * People popularity
     * @return float
     */
    public function getPopularity() : float;
}
