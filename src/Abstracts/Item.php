<?php

namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\CurlRequest;

abstract class Item extends Element
{

    protected $id   = null;
    protected $tmdb = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $item_id
     * @param array $options
     * @param string $item_name
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, int $item_id, array $options, string $item_name)
    {
        try
        {
            $this->id   = (int) $item_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();
            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest(new CurlRequest(), $item_name . '/' . (int) $item_id, null, $params);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }


}
