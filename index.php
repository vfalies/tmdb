<?php

require 'classes/Tmdb/Movie.php';

$api_key = '62dfe9839b8937e595e325a4144702ad';

$RagTmdb = new Rag\Tmdb\Movie($api_key);

var_dump($RagTmdb->getMovie('Rogue one'));

//var_dump($RagTmdb->searchTV('Black mirror'));