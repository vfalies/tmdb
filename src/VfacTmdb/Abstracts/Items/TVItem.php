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
 * @copyright Copyright (c) 2017
 */


namespace VfacTmdb\Abstracts\Items;

use VfacTmdb\Results;
use VfacTmdb\Abstracts\Item;
use VfacTmdb\Traits\ElementTrait;

/**
 * abstract TV item class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
abstract class TVItem extends Item
{
    use ElementTrait;

    /**
     * Season number
     * @var int
     */
    protected $season_number;
    /**
     * Episode number
     * @var int
     */
    protected $episode_number;
    /**
     * TVShow Id
     * @var  int
     */
    protected $tv_id;

    /**
     * Get posters params configuration from child object
     * @return \stdClass
     */
    protected function getPostersParams() : \stdClass
    {
        $url = 'tv/' . $this->tv_id . '/season/' . $this->season_number;
        $key = 'posters';
        if (isset($this->episode_number)) {
            $url .= '/episode/' . $this->episode_number;
            $key = 'stills';
        }
        $url .= '/images';

        $params = new \stdClass;
        $params->url = $url;
        $params->key = $key;

        return $params;
    }

    /**
     * Image posters
     * @return \Generator|Results\Image
     */
    public function getPosters() : \Generator
    {
        $params = $this->getPostersParams();
        $key    = $params->key;

        $options = [];
        $this->tmdb->checkOptionLanguage($this->params, $options);

        $data = $this->tmdb->getRequest($params->url, $options);

        foreach ($data->$key as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }
}
