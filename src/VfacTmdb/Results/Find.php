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


namespace VfacTmdb\Results;

use VfacTmdb\Abstracts;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Results;

/**
 * Class to manipulate find results
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */
class Find extends Abstracts\Results
{
    /**
     * Id
     * @var int
     */
    protected $id;
    /**
     * Movie results
     * @var array
     */
    protected $movie_results;
    /**
     * Person results
     * @var array
     */
    protected $person_results;
    /**
     * TV results
     *
     * @var array
     */
    protected $tv_results;
    /**
     * TV episode results
     *
     * @var array
     */
    protected $tv_episode_results;
    /**
     * TV season results
     *
     * @var array
     */
    protected $tv_season_results;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $id
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        $result->id = 0;

        parent::__construct($tmdb, $result);

        $this->id                 = $result->id;
        $this->movie_results      = $result->movie_results;
        $this->person_results     = $result->person_results;
        $this->tv_results         = $result->tv_results;
        $this->tv_episode_results = $result->tv_episode_results;
        $this->tv_season_results  = $result->tv_season_results;
    }

    /**
     * Id
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get movies
     *
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        foreach ($this->movie_results as $movie) {
            yield new Results\Movie($this->tmdb, $movie);
        }
    }

    /**
     * Get peoples
     *
     * @return \Generator|Results\People
     */
    public function getPeoples() : \Generator
    {
        foreach ($this->person_results as $person) {
            yield new Results\People($this->tmdb, $person);
        }
    }

    /**
     * Get TV shows
     *
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        foreach ($this->tv_results as $tvshow) {
            yield new Results\TVShow($this->tmdb, $tvshow);
        }
    }

    /**
     * Get TV episodes
     *
     * @return \Generator|Results\TVEpisode
     */
    public function getTVEpisodes() : \Generator
    {
        foreach ($this->tv_episode_results as $tvepisode) {
            yield new Results\TVEpisode($this->tmdb, $tvepisode);
        }
    }

    /**
     * Get TV seasons
     *
     * @return \Generator|Results\TVSeason
     */
    public function getTVSeasons() : \Generator
    {
        foreach ($this->tv_season_results as $tvseason) {
            yield new Results\TVSeason($this->tmdb, $tvseason);
        }
    }
}
