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


namespace vfalies\tmdb\Interfaces\Results;

/**
 * Interface for Movie results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface MovieResultsInterface extends ResultsInterface
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
