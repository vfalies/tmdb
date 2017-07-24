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
 * Interface for TVEpisode type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TVEpisodeInterface
{
    /**
     * Id
     */
    public function getId();

    /**
     * Air Date
     */
    public function getAirDate();

    /**
     * Season Number
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

    /**
     * Crew
     */
    public function getCrew();

    /**
     * Episode number
     */
    public function getEpisodeNumber();

    /**
     * Guests stars
     */
    public function getGuestStars();

    /**
     * Production code
     */
    public function getProductionCode();

    /**
     * Image still path
     */
    public function getStillPath();

    /**
     * Note
     */
    public function getNote();

    /**
     * Note count
     */
    public function getNoteCount();
}
