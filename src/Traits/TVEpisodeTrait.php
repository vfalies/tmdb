<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Traits;

use vfalies\tmdb\Results\Crew;

trait TVEpisodeTrait
{

    public function getCrew()
    {
        if ( ! empty($this->data->crew))
        {
            foreach ($this->data->crew as $crew)
            {
                $crew->gender = null;

                $return = new Crew($this->tmdb, $crew);
                yield $return;
            }
        }
    }

}
