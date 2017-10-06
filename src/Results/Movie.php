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


namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Interfaces\Results\MovieResultsInterface;
use vfalies\tmdb\Traits\ElementTrait;
use vfalies\tmdb\Traits\Results\ShowTrait;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Movie results class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Movie extends Results implements MovieResultsInterface
{
    /**
     * Image poster path
     * @var string
     */
    protected $poster_path = null;
    /**
     * Image backdrop path
     * @var string
     */
    protected $backdrop_path = null;

    use ElementTrait;
    use ShowTrait;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->release_date   = $this->data->release_date;
        $this->original_title = $this->data->original_title;
        $this->title          = $this->data->title;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;
    }
}
