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


namespace vfalies\tmdb\Interfaces;

/**
 * Interface for People type object
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
interface PeopleInterface
{
    /**
     * Adult
     */
    public function getAdult();

    /**
     * People also known as
     */
    public function getAlsoKnownAs();

    /**
     * Biography
     */
    public function getBiography();

    /**
     * People birthday
     */
    public function getBirthday();

    /**
     * People deathday
     */
    public function getDeathday();

    /**
     * Gender
     */
    public function getGender();

    /**
     * Homepage
     */
    public function getHomepage();

    /**
     * Id
     */
    public function getId();

    /**
     * Imdb Id
     */
    public function getImdbId();

    /**
     * People name
     */
    public function getName();

    /**
     * People place of birth
     */
    public function getPlaceOfBirth();

    /**
     * People popularity
     */
    public function getPopularity();

    /**
     * Image profile path
     */
    public function getProfilePath();
}
