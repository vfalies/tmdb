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

namespace VfacTmdb\Interfaces\Items;

/**
 * Interface for People type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface PeopleInterface
{
    /**
     * Adult
     * @return bool
     */
    public function getAdult() : bool;

    /**
     * People also known as
     * @return array
     */
    public function getAlsoKnownAs() : array;

    /**
     * Biography
     * @return string
     */
    public function getBiography() : string;

    /**
     * People birthday
     * @return string
     */
    public function getBirthday() : string;

    /**
     * People deathday
     * @return string
     */
    public function getDeathday() : string;

    /**
     * Gender
     * @return int
     */
    public function getGender() : int;

    /**
     * Homepage
     * @return string
     */
    public function getHomepage() : string;

    /**
     * Id
     * @return int
     */
    public function getId() : int;

    /**
     * Imdb Id
     * @return string
     */
    public function getImdbId() : string;

    /**
     * People name
     * @return string
     */
    public function getName() : string;

    /**
     * People place of birth
     * @return string
     */
    public function getPlaceOfBirth() : string;

    /**
     * People popularity
     * @return float
     */
    public function getPopularity() : float;

    /**
     * Image profile path
     * @return string
     */
    public function getProfilePath() : string;
}
