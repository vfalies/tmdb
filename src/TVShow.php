<?php

namespace Vfac\Tmdb;

class TVShow
{

    private $id   = null;
    private $tmdb = null;
    private $conf = null;
    private $data = null;

    public function __construct(Tmdb $tmdb, int $tv_id, array $options = array())
    {
        try
        {
            $this->id   = $tv_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();

            // Get tvshow details
            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest('tv/' . (int) $tv_id, null, $params);
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
    public function getId(): int
    {
        return $this->id;
    }

}
