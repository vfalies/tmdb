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


namespace VfacTmdb\Abstracts\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * abstract item class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
abstract class PeopleItemCredit extends Item
{
    /**
     * People item crew class name
     * @var string
     */
    public $crew_class;
    /**
     * People item cast class name
     * @var string
     */
    public $cast_class;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param string $item_type (possible value : movie / tv)
     * @param int $item_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, string $item_type, int $item_id, array $options = array())
    {
        try {
            $this->tmdb   = $tmdb;
            $this->logger = $tmdb->getLogger();

            $this->tmdb->checkOptionLanguage($options, $this->params);

            $this->data = $this->tmdb->getRequest('person/' . $item_id . '/' . $item_type . '_credits', $this->params);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Crew
     * @return \Generator
     */
    public function getCrew() : \Generator
    {
        if (!empty($this->data->crew)) {
            foreach ($this->data->crew as $c) {
                $crew_class = $this->crew_class;
                $crew = new $crew_class($this->tmdb, $c);
                yield $crew;
            }
        }
    }

    /**
     * Cast
     * @return \Generator
     */
    public function getCast() : \Generator
    {
        if (!empty($this->data->cast)) {
            foreach ($this->data->cast as $c) {
                $cast_class = $this->cast_class;
                $cast = new $cast_class($this->tmdb, $c);
                yield $cast;
            }
        }
    }
}
