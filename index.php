<?php

require 'classes/Tmdb/Tmdb.php';
require 'classes/Tmdb/Movie.php';
require 'classes/Tmdb/TVShow.php';

$api_key = '62dfe9839b8937e595e325a4144702ad';

$VfacTmdb = new Vfac\Tmdb\Tmdb($api_key);
$VfacTmdb->setLanguage('fr-FR');

$results = $VfacTmdb->searchMovie('star wars');
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
}
//var_dump($RagTmdb->searchTV('Black mirror'));