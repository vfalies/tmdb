<?php

namespace Rag\Tmdb;

require 'Tmdb.php';

class TVShow extends \Rag\Tmdb
{

    public function searchTV($query)
    {
        $this->response = $this->sendRequest('search/tv', $query);
        return $this->response;
    }

}
