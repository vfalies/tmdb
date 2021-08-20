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

use VfacTmdb\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * TVShow Credit class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2021
 */
class TVShowCredit
{
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    private $tmdb = null;
    /**
     * Logger object
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;
    /**
     * Params
     * @var array
     */
    protected $params = null;
    /**
     * Data
     * @var \stdClass
     */
    protected $data = null;
    /**
     * Crew
     * @var \stdClass
     */
    protected $crew;
    /**
     * Options array
     * @var array
     */
    protected $options;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $tvshow_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $tvshow_id, array $options = array())
    {
        $this->tmdb    = $tmdb;
        $this->logger  = $tmdb->getLogger();
        $this->data    = $this->tmdb->getRequest('tv/' . $tvshow_id . '/credits');
        $this->options = $options;
    }

    /**
     * Crew
     * @return \Generator|Results\Crew
     */
    public function getCrew() : \Generator
    {
        foreach ($this->data->crew as $c) {
            $crew = new Results\Crew($this->tmdb, $c);
            yield $crew;
        }
    }

    /**
     * Cast
     * @return \Generator|Results\Cast
     */
    public function getCast() : \Generator
    {
        foreach ($this->data->cast as $c) {
            $cast = new Results\Cast($this->tmdb, $c);
            yield $cast;
        }
    }
}
