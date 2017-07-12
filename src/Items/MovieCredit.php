<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *

 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Results\Crew;
use vfalies\tmdb\Results\Cast;

/**
 * Movie Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class MovieCredit extends Item
{
    /**
     * Crew
     * @var \stdClass
     */
    protected $crew;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $movie_id, array $options = array())
    {
        parent::__construct($tmdb, '/credits', $options, 'movie/'.$movie_id);
    }

    /**
     * Crew
     * @return \Generator|Results\Crew
     */
    public function getCrew()
    {
        if (!empty($this->data->crew))
        {
            foreach ($this->data->crew as $c)
            {
                $crew = new Crew($this->tmdb, $c);
                yield $crew;
            }
        }
    }

    /**
     * Cast
     * @return \Generator|Results\Cast
     */
    public function getCast()
    {
        if (!empty($this->data->cast))
        {
            foreach ($this->data->cast as $c)
            {
                $cast = new Cast($this->tmdb, $c);
                yield $cast;
            }
        }
    }

}