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
use vfalies\tmdb\Interfaces\Results\CastResultsInterface;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a movie or tv show cast result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Cast extends Results implements CastResultsInterface
{
    /**
     * Character name
     * @var string
     */
    protected $character = null;
    /**
     * Gender
     * @var string
     */
    protected $gender = null;
    /**
     * Credit Id
     * @var string
     */
    protected $credit_id = null;
    /**
     * Cast Id
     * @var int
     */
    protected $cast_id = null;
    /**
     * Name
     * @var string
     */
    protected $name = null;
    /**
     * Image profile path
     * @var string
     */
    protected $profile_path = null;
    /**
     * Order in cast
     * @var int
     */
    protected $order = null;
    /**
     * Id
     * @var int
     */
    protected $id = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id           = $this->data->id;
        $this->character    = $this->data->character;
        $this->gender       = $this->data->gender;
        $this->credit_id    = $this->data->credit_id;
        $this->cast_id      = $this->data->cast_id;
        $this->name         = $this->data->name;
        $this->profile_path = $this->data->profile_path;
        $this->order        = $this->data->order;
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
     * Get gender
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get Cast Id
     * @return int
     */
    public function getCastId()
    {
        return $this->cast_id;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get profile path
     * @return string
     */
    public function getProfilePath()
    {
        return $this->profile_path;
    }

    /**
     * Get Order
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

}
