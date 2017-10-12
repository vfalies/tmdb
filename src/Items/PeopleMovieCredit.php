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


namespace VfacTmdb\Items;

use VfacTmdb\Results;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Abstracts\Item;
use VfacTmdb\Results\PeopleMovieCast;
use VfacTmdb\Results\PeopleMovieCrew;

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
        try {
            $this->tmdb   = $tmdb;
            $this->logger = $tmdb->getLogger();
            $this->params = $this->tmdb->checkOptions($options);
            $this->data   = $this->tmdb->getRequest('person/' . $people_id.'/movie_credits', $this->params);
        } catch (TmdbException $ex) {
            throw $ex;
        }
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
