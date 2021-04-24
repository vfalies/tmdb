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
 * @copyright Copyright (c) 2017-2021
 */

namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for Item Change results type object
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2021
 */
interface ItemChangeResultsInterface
{
    /**
     * Get ID
     * @return string
     */
    public function getId() : string;

    /**
     * Get key
     * @return string
     */
    public function getKey() : string;

    /**
     * Get action
     * @return string
     */
    public function getAction() : string;

    /**
     * Get time
     * @return \DateTime
     */
    public function getTime() : \DateTime;

    /**
     * Get iso_639_1
     *
     * @return  string
     */
    public function getIso_639_1() : string;

    /**
     * Get iso_3166_1
     *
     * @return  string
     */
    public function getIso_3166_1() : string;

    /**
     * Get value
     *
     * @return  array
     */
    public function getValue() : array;

    /**
     * Get original value
     *
     * @return  array|null
     */
    public function getOriginalValue() : ?array;

    /**
     * Get value by key
     * @param   string  $key
     * @return  mixed
     */
    public function getValueByKey($key);
}
