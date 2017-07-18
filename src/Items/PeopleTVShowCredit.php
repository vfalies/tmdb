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

use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Results\PeopleTVShowCast;
use vfalies\tmdb\Results\PeopleTVShowCrew;

/**
 * People TVShow Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class PeopleTVShowCredit extends Item
{
    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param int $people_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, $people_id, array $options = array())
    {
        parent::__construct($tmdb, '/tv_credits', $options, 'person/' . $people_id);
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
                $crew = new PeopleTVShowCrew($this->tmdb, $c);
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
                $cast = new PeopleTVShowCast($this->tmdb, $c);
                yield $cast;
            }
        }
    }
}
