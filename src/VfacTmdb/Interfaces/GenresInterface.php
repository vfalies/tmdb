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


namespace VfacTmdb\Interfaces;

/**
 * Interface for Genres type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface GenresInterface
{
    /**
     * TV genres list
     * @param array $options
     */
    public function getTVList(array $options = array());

    /**
     * Movie genres list
     * @param array $options
     */
    public function getMovieList(array $options = array());
}
