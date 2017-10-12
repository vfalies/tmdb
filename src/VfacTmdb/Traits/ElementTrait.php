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


namespace VfacTmdb\Traits;

/**
 * Common element methods trait
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait ElementTrait
{

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath() : string
    {
        if (isset($this->data->poster_path)) {
            return $this->data->poster_path;
        }
        return '';
    }

    /**
     * Get backdrop
     * @return string
     */
    public function getBackdropPath() : string
    {
        if (isset($this->data->backdrop_path)) {
            return $this->data->backdrop_path;
        }
        return '';
    }
}
