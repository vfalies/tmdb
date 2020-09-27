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
    public $page = 1;
    /**
     * Total pages
     * @var int
     */
    public $total_pages = 1;
    /**
     * Total results
     * @var int
     */
    public $total_results = 0;

    /**
     * Get page from result search
     * @return int
     */
    public function getPage() : int
    {
        return $this->page;
    }

    /**
     * Get total page from result search
     * @return int
     */
    public function getTotalPages() : int
    {
        return $this->total_pages;
    }

    /**
     * Get total results from search
     * @return int
     */
    public function getTotalResults() : int
    {
        return $this->total_results;
    }
}
