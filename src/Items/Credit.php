<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Results\Crew;
use vfalies\tmdb\Results\Cast;

class Credit extends Item
{
    protected $crew;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $movie_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $movie_id, array $options = array())
    {
        parent::__construct($tmdb, '/credits', $options, 'movie/'.$movie_id);
    }

    public function getCrew()
    {
        if (!empty($this->data->crew))
        {
            foreach ($this->data->crew as $c)
            {
                $crew = new Crew($this->tmdb, $c);
                yield $crew;
            }
        }
    }

    public function getCast()
    {
        if (!empty($this->data->cast))
        {
            foreach ($this->data->cast as $c)
            {
                $cast = new Cast($this->tmdb, $c);
                yield $cast;
            }
        }
    }

}