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


namespace vfalies\tmdb\Interfaces\Items;

/**
 * Interface for TVSeason type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TVSeasonInterface
{
    /**
     * Id
     */
    public function getId();

    /**
     * Image poster path
     */
    public function getPosterPath();

    /**
     * Episode count
     */
    public function getEpisodeCount();

    /**
     * Episodes list
     */
    public function getEpisodes();

    /**
     * Air date
     */
    public function getAirDate();

    /**
     * Season number
     */
    public function getSeasonNumber();

    /**
     * Name
     */
    public function getName();

    /**
     * Overview
     */
    public function getOverview();
}
