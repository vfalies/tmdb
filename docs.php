<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in('src')
;

return new Sami($iterator, array(
    'title'                => 'Tmdb - PHP Wrapper for The Movie Database API V3',
    'build_dir'            => __DIR__.'/docs',
    'cache_dir'            => __DIR__.'/docs/cache',
    'default_opened_level' => 2,
));
