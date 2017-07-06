<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;

class Credit extends Item
{
    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $movie_id, array $options = array())
    {
        //parent::__construct($tmdb, $movie_id, $options, 'movie');
    }

}