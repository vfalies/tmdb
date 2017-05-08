<?php

require 'classes/Tmdb/Tmdb.php';
require 'classes/Tmdb/Movie.php';
require 'classes/Tmdb/TVShow.php';

$api_key = '62dfe9839b8937e595e325a4144702ad';

$VfacTmdb = new Vfac\Tmdb\Tmdb($api_key);

$results = [];
//$results = $VfacTmdb->searchMovie('star wars', array('language' => 'fr-FR'));
$results[] = $VfacTmdb->getMovieDetails(11, array('language' => 'fr-FR')); // star wars

foreach ($results as $movie)
{
    echo <<<RES
        {$movie->getId()}<br />
        {$movie->getTitle()}<br />
        {$movie->getOriginalTitle()}<br />
        {$movie->getOverview()}<br />
        {$movie->getNote()}<br />
        {$movie->getReleaseDate()}<br />
        {$movie->getPoster()}<br />
        {$movie->getBackdrop()}<br />
        {$movie->getGenres()}<br />
        <hr />
RES;
    echo $movie->raw;
}

