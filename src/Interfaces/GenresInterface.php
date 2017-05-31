<?php

namespace Vfac\Tmdb\Interfaces;

interface GenresInterface
{

    public function getTVList(array $options = array()): \Generator;

    public function getMovieList(array $options = array()): \Generator;
}
