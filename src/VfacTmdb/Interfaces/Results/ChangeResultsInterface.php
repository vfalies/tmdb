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
 * @copyright Copyright (c) 2017-2020
 */

namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for Change results type object
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2017-2020
 */
interface ChangeResultsInterface extends ResultsInterface
{
    /**
     * Get item adult status
     * @return string
     */
    public function getAdult() : bool;
}
