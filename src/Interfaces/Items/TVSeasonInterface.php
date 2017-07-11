<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
* @package Tmdb 
* @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Interfaces\Items;

interface TVSeasonInterface
{
    public function getId();

    public function getPosterPath();

    public function getEpisodeCount();

    public function getEpisodes();

    public function getAirDate();

    public function getSeasonNumber();

    public function getName();

    public function getOverview();
}
