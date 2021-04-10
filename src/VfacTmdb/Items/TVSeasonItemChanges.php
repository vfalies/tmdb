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
 * @copyright Copyright (c) 2017-2021
 */


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Items\ItemChanges;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * TV Season Item Changes class
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2021
 */
class TVSeasonItemChanges extends ItemChanges
{
    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $season_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $season_id, array $options = array())
    {
        try {
            parent::__construct($tmdb, 'tv/season', $season_id, $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
