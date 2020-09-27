<?php declare(strict_types=1);
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Interfaces\Items\TVNetworkInterface;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Results;

/**
 * TVNetwork class
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2017-2020
 */
class TVNetwork extends Item implements TVNetworkInterface
{
    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $network_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $network_id, array $options = array())
    {
        parent::__construct($tmdb, $network_id, $options, 'network');
    }

    /**
     * Get TV Network id
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get TV Network name
     * @return string
     */
    public function getName() : string
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Get TV Network headquarters
     * @return string
     */
    public function getHeadquarters() : string
    {
        if (isset($this->data->headquarters)) {
            return $this->data->headquarters;
        }
        return '';
    }

    /**
     * Get TV Network homepage
     * @return string
     */
    public function getHomepage() : string
    {
        if (isset($this->data->homepage)) {
            return $this->data->homepage;
        }
        return '';
    }

    /**
     * Get TV Network origin country
     * @return string
     */
    public function getOriginCountry() : string
    {
        if (isset($this->data->origin_country)) {
            return $this->data->origin_country;
        }
        return '';
    }

    /**
     * Alternative names list
     * @return \Generator|Results\AlternativeName
     */
    public function getAlternativeNames() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('network/' . (int) $this->id . '/alternative_names', $params);

        foreach ($data->results as $n) {
            $name = new Results\AlternativeName($this->tmdb, $this->id, $n);
            yield $name;
        }
    }

    /**
     * Logos list
     * @return \Generator|Results\Logo
     */
    public function getLogos() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('network/' . (int) $this->id . '/images', $params);

        foreach ($data->logos as $logo) {
            $image = new Results\Logo($this->tmdb, $this->id, $logo);
            yield $image;
        }
    }
}
