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
 * @copyright Copyright (c) 2017-2020
 */


namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for Videos results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */
interface VideosResultsInterface
{

    /**
     * Get iso_639_1
     *
     * @return  string
     */
    public function getIso_639_1() : string;

    /**
     * Get iso_3166_1
     *
     * @return  string
     */
    public function getIso_3166_1() : string;

    /**
     * Get key
     *
     * @return  string
     */
    public function getKey() : string;

    /**
     * Get name
     *
     * @return  string
     */
    public function getName() : string;

    /**
     * Get site
     *
     * @return  string
     */
    public function getSite() : string;

    /**
     * Get size
     *
     * @return  int
     */
    public function getSize() : int;

    /**
     * Get type
     *
     * @return  string
     */
    public function getType() : string;
}
