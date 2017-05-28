<?php


require '../vendor/autoload.php';

use Vfac\Tmdb\Tmdb;
use Vfac\Tmdb\Search;
//use Vfac\Tmdb\SearchMovieResult;
//use Vfac\Tmdb\SearchTVShowResult;
//use Vfac\Tmdb\SearchCollectionResult;

$tmdb = new Tmdb('62dfe9839b8937e595e325a4144702ad');

$search  = new Search($tmdb);
$results = $search->searchMovie('star wars', array('language' => 'fr-FR'));
//$results = $search->searchMovie('star wars', array('languagedsqddsq' => 'fr-FR'));

var_dump($results, $results->current());


//if ( ! is_null($results->current()))
//{
//    $res = $search->getMovie($results->current()->getId());
//
//    echo '<pre>';
//    var_dump($res->getTitle().' ('.$res->getReleaseDate().')');
//    var_dump('Collection : '.$res->getCollectionId());
//
//    $collection = $search->getCollection($res->getCollectionId(), array('language' => 'fr-FR'));
//
//    var_dump($collection->getName());
//
//    foreach ($collection->getParts() as $part)
//    {
//        var_dump($part->getTitle());
//    }
//    echo '</pre>';
//}
//else
//{
//    echo 'Aucun résultat';
//}
