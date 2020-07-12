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


namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\Results\TVShowResultsInterface;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Traits\Results\ShowTrait;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a TV Show result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class TVShow extends Results implements TVShowResultsInterface
{
    /**
     * Image backdrop path
     * @var string
     */
    protected $backdrop_path = null;
    /**
     * Image poster path
     * @var string
     */
    protected $poster_path = null;

    use ElementTrait;
    use ShowTrait;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        array_push($this->property_blacklist, 'release_date'); // For renaming first_air_date to release_date
        array_push($this->property_blacklist, 'original_title'); // For renaming original_name to original_title
        array_push($this->property_blacklist, 'title'); // For renaming name to title

        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->release_date   = $this->data->first_air_date;
        $this->original_title = $this->data->original_name;
        $this->title          = $this->data->name;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;

        $this->setElementTrait($this->data);
    }
}
