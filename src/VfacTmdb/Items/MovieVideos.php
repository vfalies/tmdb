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
 * @copyright Copyright (c) 2017-2020
 */


namespace VfacTmdb\Items;

use VfacTmdb\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Movie Videos class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */
class MovieVideos
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
     * Options array
     * @var array
     */
    protected $options;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $movie_id, array $options = array())
    {
        $this->tmdb    = $tmdb;
        $this->logger  = $tmdb->getLogger();
        $this->data    = $this->tmdb->getRequest('movie/' . $movie_id . '/videos');
        $this->options = $options;
    }

    public function getVideos() : \Generator
    {
        if (!empty($this->data->results)) {
            foreach ($this->data->results as $r) {
                $video = new Results\Videos($this->tmdb, $r);
                yield $video;
            }
        }
    }
}
