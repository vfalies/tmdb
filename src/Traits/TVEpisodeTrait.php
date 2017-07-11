<?php

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
