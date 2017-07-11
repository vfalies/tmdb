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

interface PeopleInterface
{

    public function getAdult();

    public function getAlsoKnownAs();

    public function getBiography();

    public function getBirthday();

    public function getDeathday();

    public function getGender();

    public function getHomepage();

    public function getId();

    public function getImdbId();

    public function getName();

    public function getPlaceOfBirth();

    public function getPopularity();

    public function getProfilePath();
}
