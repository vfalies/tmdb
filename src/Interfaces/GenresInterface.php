<?php

namespace vfalies\tmdb\Interfaces;

interface GenresInterface
{

    public function getTVList(array $options = array()): \Generator;

    public function getMovieList(array $options = array()): \Generator;
}
