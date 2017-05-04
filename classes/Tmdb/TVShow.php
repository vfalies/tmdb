<?php

namespace Vfac\Tmdb;

require 'Tmdb.php';

class TVShow extends \Vfac\Tmdb
{

    public function searchTV($query)
    {
        $this->response = $this->sendRequest('search/tv', $query);
        return $this->response;
    }

}
