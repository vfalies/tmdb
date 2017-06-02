<?php

namespace vfalies\tmdb\Items;

abstract class Item
{
    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $item_id
     * @param array $options
     * @param string $item_name
     * @throws \Exception
     */
    public function __construct(\vfalies\tmdb\Tmdb $tmdb, int $item_id, array $options, string $item_name)
    {
        try
        {
            $this->id   = (int) $item_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();
            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest(new \vfalies\tmdb\CurlRequest(), $item_name . '/'.(int) $item_id, null, $params);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

}
