<?php

require 'Tmdb.php';
require 'Search.php';
require 'Movie.php';
require 'Collection.php';
require 'SearchMovieResult.php';

use Vfac\Tmdb\Tmdb;
use Vfac\Tmdb\Search;

$tmdb = new Tmdb('62dfe9839b8937e595e325a4144702ad');

$search  = new Search($tmdb);
$results = $search->searchMovie('star wars', array('language' => 'fr-FR'));

//foreach ($results as $movie)
//{
//    $res = $search->getMovie($movie->id);
//
//    echo '<pre>';
//    var_dump($res->getTitle().' ('.$res->getReleaseDate().')');
//    echo '</pre>';
//}

$res = $search->getMovie($results->current()->getId());

echo '<pre>';
var_dump($res->getTitle().' ('.$res->getReleaseDate().')');
var_dump('Collection : '.$res->getCollectionId());

$collection = $search->getCollection($res->getCollectionId(), array('language' => 'fr-FR'));

var_dump($collection->getName());

foreach ($collection->getParts() as $part)
{
    var_dump($part->getTitle());
}
echo '</pre>';
