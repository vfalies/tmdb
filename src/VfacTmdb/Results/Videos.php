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


namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\Results\VideosResultsInterface;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a videos result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */
class Videos extends Results implements VideosResultsInterface
{
    /**
     * Iso_639_1
     * @var string
     */
    protected $iso_639_1 = null;
    /**
     * Iso_3166_1
     * @var string
     */
    protected $iso_3166_1 = null;
    /**
     * Key
     * @var string
     */
    protected $key = null;
    /**
     * Name
     * @var string
     */
    protected $name = null;
    /**
     * Site
     * @var string
     */
    protected $site = null;
    /**
     * Id
     * @var string
     */
    protected $id = null;
    /**
     * Size
     *
     * @var int
     */
    protected $size = null;
    /**
     * Type
     *
     * @var string
     */
    protected $type = null;
    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id         = $this->data->id;
        $this->iso_639_1  = $this->data->iso_639_1;
        $this->iso_3166_1 = $this->data->iso_3166_1;
        $this->key        = $this->data->key;
        $this->name       = $this->data->name;
        $this->site       = $this->data->site;
        $this->size       = $this->data->size;
        $this->type       = $this->data->type;
    }

    /**
     * Get iso_639_1
     *
     * @return  string
     */
    public function getIso_639_1() : string
    {
        return $this->iso_639_1;
    }

    /**
     * Get iso_3166_1
     *
     * @return  string
     */
    public function getIso_3166_1() : string
    {
        return $this->iso_3166_1;
    }

    /**
     * Get key
     *
     * @return  string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * Get name
     *
     * @return  string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get site
     *
     * @return  string
     */
    public function getSite() : string
    {
        return $this->site;
    }

    /**
     * Get size
     *
     * @return  int
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * Get type
     *
     * @return  string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }
}
