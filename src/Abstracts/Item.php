<?php

namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\Traits\ElementTrait;

abstract class Item
{
    protected $id     = null;
    protected $tmdb   = null;
    protected $logger = null;
    protected $conf   = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $item_id
     * @param array $options
     * @param string $item_name
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, $item_id, array $options, $item_name)
    {
        try
        {
            $this->id     = (int) $item_id;
            $this->tmdb   = $tmdb;
            $this->logger = $tmdb->logger;
            $this->conf   = $this->tmdb->getConfiguration();
            $params       = $this->tmdb->checkOptions($options);
            $this->data   = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), $item_name.'/'.(int) $item_id, null, $params);
        }
        catch (TmdbException $ex)
        {
            throw $ex;
        }
    }

}
