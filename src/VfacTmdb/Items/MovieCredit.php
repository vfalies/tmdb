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
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Movie Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class MovieCredit
{
    /**
     * Crew
     * @var \stdClass
     */
    protected $crew;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $movie_id, array $options = array())
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
        $this->params = $this->tmdb->checkOptions($options);
        $this->data   = $this->tmdb->getRequest('movie/' . $movie_id . '/credits', $this->params);
    }

    /**
     * Crew
     * @return \Generator|Results\Crew
     */
    public function getCrew() : \Generator
    {
        if (!empty($this->data->crew)) {
            foreach ($this->data->crew as $c) {
                $crew = new Results\Crew($this->tmdb, $c);
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
                $cast = new Results\Cast($this->tmdb, $c);
                yield $cast;
            }
        }
    }
}
