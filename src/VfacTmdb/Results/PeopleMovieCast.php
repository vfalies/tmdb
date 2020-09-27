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

namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\TmdbInterface;

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
     * @var bool
     */
    protected $adult = false;

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
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Get credit Id
     * @return string
     */
    public function getCreditId() : string
    {
        return $this->credit_id;
    }

    /**
     * Get character name
     * @return string
     */
    public function getCharacter() : string
    {
        return $this->character;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Get original title
     * @return string
     */
    public function getOriginalTitle() : string
    {
        return $this->original_title;
    }

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath() : string
    {
        return $this->poster_path;
    }

    /**
     * Get release date
     * @return string
     */
    public function getReleaseDate() : string
    {
        return $this->release_date;
    }

    /**
     * Adult
     * @return bool
     */
    public function getAdult() : bool
    {
        return $this->adult;
    }
}
