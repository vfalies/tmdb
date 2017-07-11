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


namespace vfalies\tmdb\Interfaces\Results;

interface CrewResultsInterface {

    public function getCreditId();

    public function getDepartment();

    public function getGender();

    public function getJob();

    public function getName();

    public function getProfilePath();
}