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


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Items\PeopleItemCredit;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Results\PeopleMovieCast;
use VfacTmdb\Results\PeopleMovieCrew;

/**
 * People Movie Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class PeopleMovieCredit extends PeopleItemCredit
{
    public function __construct(TmdbInterface $tmdb, int $people_id, array $options = array())
    {
        try {
            $this->crew_class = PeopleMovieCrew::class;
            $this->cast_class = PeopleMovieCast::class;

            parent::__construct($tmdb, 'movie', $people_id, $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
