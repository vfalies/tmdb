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


namespace vfalies\tmdb\Items;

use vfalies\tmdb\Results;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Results\PeopleMovieCast;
use vfalies\tmdb\Results\PeopleMovieCrew;

/**
 * People Movie Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class PeopleMovieCredit extends Item
{
    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $people_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $people_id, array $options = array())
    {
        parent::__construct($tmdb, $people_id, $options, 'person/' . $people_id.'/movie_credits');
    }

    /**
     * Crew
     * @return \Generator|Results\PeopleMovieCrew
     */
    public function getCrew() : \Generator
    {
        if (!empty($this->data->crew)) {
            foreach ($this->data->crew as $c) {
                $crew = new PeopleMovieCrew($this->tmdb, $c);
                yield $crew;
            }
        }
    }

    /**
     * Cast
     * @return \Generator|Results\Cast
     */
    public function getCast() : \Generator
    {
        if (!empty($this->data->cast)) {
            foreach ($this->data->cast as $c) {
                $cast = new PeopleMovieCast($this->tmdb, $c);
                yield $cast;
            }
        }
    }
}
