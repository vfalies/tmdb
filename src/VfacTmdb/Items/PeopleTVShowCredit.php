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
use VfacTmdb\Results\PeopleTVShowCast;
use VfacTmdb\Results\PeopleTVShowCrew;

/**
 * People TVShow Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
    class PeopleTVShowCredit extends PeopleItemCredit
    {
        public function __construct(TmdbInterface $tmdb, int $people_id, array $options = array())
        {
            try {
                $this->crew_class = PeopleTVShowCrew::class;
                $this->cast_class = PeopleTVShowCast::class;

                parent::__construct($tmdb, 'tv', $people_id, $options);
            } catch (TmdbException $ex) {
                throw $ex;
            }
        }
    }
