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
 * Interface for Collection results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
interface TVShowResultsInterface extends ResultsInterface
{

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview();

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle();

    /**
     * Get movie title
     * @return string
     */
    public function getTitle();


    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate();
}
