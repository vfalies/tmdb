<?php

namespace Vfac\Tmdb;

class TVShow
{

    private $id    = null;
    private $_tmdb = null;
    private $_conf = null;
    private $_data = null;

    public function __construct(Tmdb $tmdb, $tv_id, array $options = array())
    {
        try
        {
            $this->id    = (int) $tv_id;
            $this->_tmdb = $tmdb;
            $this->_conf = $this->_tmdb->getConfiguration();

            // Get tvshow details
            $params      = $this->_tmdb->checkOptions($options);
            $this->_data = $this->_tmdb->sendRequest('tv/'.(int) $tv_id, null, $params);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
