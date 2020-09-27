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
 * Interface for TVEpisode type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TVEpisodeInterface
{
    /**
     * Id
     * @return int
     */
    public function getId() : int;

    /**
     * Air Date
     * @return string
     */
    public function getAirDate() : string;

    /**
     * Season Number
     * @return int
     */
    public function getSeasonNumber() : int;

    /**
     * Name
     * @return string
     */
    public function getName() : string;

    /**
     * Overview
     * @return string
     */
    public function getOverview() : string;

    /**
     * Crew
     * @return \Generator
     */
    public function getCrew() : \Generator;

    /**
     * Episode number
     * @return int
     */
    public function getEpisodeNumber() : int;

    /**
     * Guests stars
     * @return \Generator
     */
    public function getGuestStars() : \Generator;

    /**
     * Production code
     * @return string
     */
    public function getProductionCode() : string;

    /**
     * Image still path
     * @return string
     */
    public function getStillPath() : string;

    /**
     * Note
     * @return float
     */
    public function getNote() : float;

    /**
     * Note count
     * @return int
     */
    public function getNoteCount() : int;
}
