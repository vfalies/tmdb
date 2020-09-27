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
 * Interface for TVSeason type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TVSeasonInterface
{
    /**
     * Id
     * @return int
     */
    public function getId() : int;

    /**
     * Image poster path
     * @return string
     */
    public function getPosterPath() : string;

    /**
     * Episode count
     * @return int
     */
    public function getEpisodeCount() : int;

    /**
     * Episodes list
     * @return \Generator
     */
    public function getEpisodes() : \Generator;

    /**
     * Air date
     * @return string
     */
    public function getAirDate() : string;

    /**
     * Season number
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
}
