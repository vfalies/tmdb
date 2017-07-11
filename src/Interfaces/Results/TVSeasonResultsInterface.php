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

/**
 * Interface for TVSeason results type object
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
interface TVSeasonResultsInterface extends ResultsInterface
{
    /**
     * Episode count
     */
    public function getEpisodeCount();

    /**
     * Image poster path
     */
    public function getPosterPath();

    /**
     * Season number
     */
    public function getSeasonNumber();

    /**
     * Get movie release date
     * @return string
     */
    public function getAirDate();
}
