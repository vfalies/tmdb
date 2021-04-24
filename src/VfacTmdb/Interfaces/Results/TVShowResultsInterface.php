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


namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for TVShow results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TVShowResultsInterface extends ResultsInterface
{

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview() : string;

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle() : string;

    /**
     * Get movie title
     * @return string
     */
    public function getTitle() : string;


    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate() : string;
}
