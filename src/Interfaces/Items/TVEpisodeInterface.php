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

interface TVEpisodeInterface
{
    public function getId();

    public function getAirDate();

    public function getSeasonNumber();

    public function getName();

    public function getOverview();

    public function getCrew();

    public function getEpisodeNumber();

    public function getGuestStars();

    public function getProductionCode();

    public function getStillPath();

    public function getNote();

    public function getNoteCount();
}
