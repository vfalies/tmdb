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
 * TV Episode Item Changes class
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2021
 */
class TVEpisodeItemChanges extends ItemChanges
{
    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $episode_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $episode_id, array $options = array())
    {
        try {
            parent::__construct($tmdb, 'tv/episode', $episode_id, $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
