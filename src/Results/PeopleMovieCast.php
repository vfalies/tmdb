<?php

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

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a people movie cast result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class PeopleMovieCast extends Results
{

    /**
     * Adult
     * @var boolean
     */
    protected $adult = null;

    /**
     * Character name
     * @var string
     */
    protected $character = null;

    /**
     * Credit Id
     * @var string
     */
    protected $credit_id = null;

    /**
     * title
     * @var string
     */
    protected $title = null;

    /**
     * Image poster path
     * @var string
     */
    protected $poster_path = null;

    /**
     * original title
     * @var string
     */
    protected $original_title = null;

    /**
     * Release date
     * @var string
     */
    protected $release_date = null;

    /**
     * Id
     * @var int
     */
    protected $id = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id             = $this->data->id;
        $this->adult          = $this->data->adult;
        $this->character      = $this->data->character;
        $this->credit_id      = $this->data->credit_id;
        $this->original_title = $this->data->original_title;
        $this->title          = $this->data->title;
        $this->poster_path    = $this->data->poster_path;
        $this->release_date   = $this->data->release_date;
    }

    /**
     * Get Id
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Get credit Id
     * @return string
     */
    public function getCreditId()
    {
        return $this->credit_id;
    }

    /**
     * Get character name
     * @return string
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get original title
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath()
    {
        return $this->poster_path;
    }

    /**
     * Get release date
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * Adult
     * @return boolean
     */
    public function getAdult()
    {
        return $this->adult;
    }
}
