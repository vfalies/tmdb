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

namespace vfalies\tmdb\Traits;

/**
 * listItems trait
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait ListItems
{
    /**
     * Page number
     * @var int
     */
    var $page = 1;
    /**
     * Total pages
     * @var int
     */
    var $total_pages = 1;
    /**
     * Total results
     * @var int
     */
    var $total_results = 0;

    /**
     * Get page from result search
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get total page from result search
     * @return int
     */
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    /**
     * Get total results from search
     * @return int
     */
    public function getTotalResults()
    {
        return $this->total_results;
    }

}
