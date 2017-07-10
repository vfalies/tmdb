<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\CompanyInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

class Company extends Item implements CompanyInterface
{
    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $company_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $company_id, array $options = array())
    {
        parent::__construct($tmdb, $company_id, $options, 'company');
    }

    public function getDescription()
    {
        if (isset($this->data->description)) {
            return $this->data->description;
        }
        return '';
    }

    public function getHeadQuarters()
    {
        if (isset($this->data->headquarters)) {
            return $this->data->headquarters;
        }
        return '';
    }

    public function getHomePage()
    {
        if (isset($this->data->homepage)) {
            return $this->data->homepage;
        }
        return '';
    }

    public function getId()
    {
        if (isset($this->data->id)) {
            return $this->data->id;
        }
        return 0;
    }

    public function getLogoPath()
    {
        if (isset($this->data->logo_path)) {
            return $this->data->logo_path;
        }
        return '';
    }

    public function getName()
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    public function getMovies()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/company/'.(int) $this->id.'/movies', null, $this->params);

        foreach ($data->results as $m)
        {
            $movie = new \vfalies\tmdb\Results\Movie($this->tmdb, $m);
            yield $movie;
        }
    }
}
