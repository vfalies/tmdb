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
     * ElementTrait object variable
     * @var \stdClass
     */
    protected $element_trait;

    /**
     * Set ElementTrait variable
     * @param \stdClass|null $data
     * @return void
     */
    protected function setElementTrait(?\stdClass $data) : void
    {
        $this->element_trait = $data;
    }

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath() : string
    {
        if (isset($this->element_trait->poster_path)) {
            return $this->element_trait->poster_path;
        }
        return '';
    }

    /**
     * Get backdrop
     * @return string
     */
    public function getBackdropPath() : string
    {
        if (isset($this->element_trait->backdrop_path)) {
            return $this->element_trait->backdrop_path;
        }
        return '';
    }
}
