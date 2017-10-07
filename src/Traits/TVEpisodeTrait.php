<?php
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


namespace vfalies\tmdb\Traits;

use vfalies\tmdb\Results;

/**
 * TV Episode trait
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait TVEpisodeTrait
{
    /**
     * Get crew of TV Episode
     * @return \Generator|Results\Crew
     */
    public function getCrew() : \Generator
    {
        if (!empty($this->data->crew)) {
            foreach ($this->data->crew as $crew) {
                $crew->gender = null;

                $return = new Results\Crew($this->tmdb, $crew);
                yield $return;
            }
        }
    }
}
