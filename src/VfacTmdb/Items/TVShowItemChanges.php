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
 * TV Item Changes class
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2021
 */
class TVShowItemChanges extends ItemChanges
{
    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $tv_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $tv_id, array $options = array())
    {
        try {
            parent::__construct($tmdb, 'tv', $tv_id, $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Get TV Season Item Changes for this TV Show
     * @return \AppendIterator|\VfacTmdb\Results\ItemChange
     */
    public function getSeasonChanges() : \AppendIterator
    {
        $seasonChanges = new \AppendIterator();
        foreach ($this->getChangesByKey('season') as $change) {
            $seasonId = $change->getValueByKey('season_id');
            if (null !== $seasonId) {
                $seasonChanges->append(
                    (new TVSeasonItemChanges($this->tmdb, $seasonId, $this->params))
                        ->getChanges()
                );
            }
        }

        return $seasonChanges;
    }

    /**
     * Get TV Episode Item Changes for this TV Show
     * @return \AppendIterator|\VfacTmdb\Results\ItemChange
     */
    public function getEpisodeChanges() : \AppendIterator
    {
        $episodeChanges = new \AppendIterator();
        foreach ($this->getSeasonChanges() as $seasonChange) {
            if (null !== $seasonChange->getValueByKey('episode_id')) {
                $episodeChanges->append(
                    (new TVEpisodeItemChanges($this->tmdb, $seasonChange->getValueByKey('episode_id'), $this->params))
                    ->getChanges()
                );
            }
        }

        return $episodeChanges;
    }
}
