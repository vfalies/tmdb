<?php

require 'Tmdb.php';
require 'Search.php';
require 'Movie.php';
require 'Collection.php';
require 'MediaFactory.php';

use Vfac\Tmdb\Tmdb;
use Vfac\Tmdb\Search;
use Vfac\Tmdb\MediaFactory;

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

$res = $search->getMovie($results->current()->id);

echo '<pre>';
var_dump($res->getTitle().' ('.$res->getReleaseDate().')');
var_dump('Collection : '.$res->getCollectionId());

$collection = $search->getCollection($res->getCollectionId(), array('language' => 'fr-FR'));

var_dump($collection->getName());
echo '</pre>';
