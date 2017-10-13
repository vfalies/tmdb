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


namespace VfacTmdb\Traits;

use VfacTmdb\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * TV Episode trait
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait TVEpisodeTrait
{
    /**
     * TVEpisodeTrait object variable
     * @var \stdClass
     */
    protected $tvepisode_trait;

    /**
     * Set TVEpisodeTrait variable
     * @param TmdbInterface $tmdb
     * @param \stdClass|null $data
     * @return void
     */
    protected function setTVEpisodeTrait(TmdbInterface $tmdb, ?\stdClass $data) : void
    {
        $this->tvepisode_trait       = new \stdClass();
        $this->tvepisode_trait->tmdb = $tmdb;
        $this->tvepisode_trait->data = $data;
    }

    /**
     * Get crew of TV Episode
     * @return \Generator|Results\Crew
     */
    public function getCrew() : \Generator
    {
        if (!empty($this->tvepisode_trait->data->crew)) {
            foreach ($this->tvepisode_trait->data->crew as $crew) {
                $crew->gender = null;

                $return = new Results\Crew($this->tvepisode_trait->tmdb, $crew);
                yield $return;
            }
        }
    }
}
