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


namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for Cast results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface CastResultsInterface
{

    /**
     * Credit Id
     * @return string
     */
    public function getCreditId() : string;

    /**
     * Character name
     * @return string
     */
    public function getCharacter() : string;

    /**
     * Gender
     * @return string
     */
    public function getGender() : string;

    /**
     * Cast Id
     * @return int
     */
    public function getCastId() : int;

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

    /**
     * Order
     * @return int
     */
    public function getOrder() : int;
}
