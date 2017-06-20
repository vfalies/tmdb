<?php

namespace vfalies\tmdb\Interfaces;

interface GenresInterface
{

    public function getTVList(array $options = array());

    public function getMovieList(array $options = array());
}
