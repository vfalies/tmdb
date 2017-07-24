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
 * Interface for Cast results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface CastResultsInterface
{

    /**
     * Credit Id
     */
    public function getCreditId();

    /**
     * Character name
     */
    public function getCharacter();

    /**
     * Gender
     */
    public function getGender();

    /**
     * Cast Id
     */
    public function getCastId();

    /**
     * Name
     */
    public function getName();

    /**
     * Image profile path
     */
    public function getProfilePath();

    /**
     * Order
     */
    public function getOrder();
}
