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
 * @copyright Copyright (c) 2017-2021
 */

namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\Results\CastResultsInterface;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a movie or tv show cast result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2021
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
     * @var int
     */
    protected $gender = null;
    /**
     * Credit Id
     * @var string
     */
    protected $credit_id = null;

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
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        $this->id           = $this->data->id;
        $this->character    = $this->data->character;
        $this->gender       = $this->data->gender;
        $this->credit_id    = $this->data->credit_id;
        $this->name         = $this->data->name;
        $this->profile_path = $this->data->profile_path;
        $this->order        = $this->data->order;
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
     * Get gender
     * @return int
     */
    public function getGender() : int
    {
        return $this->gender;
    }

    /**
     * Get name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get profile path
     * @return string
     */
    public function getProfilePath() : string
    {
        return $this->profile_path;
    }

    /**
     * Get Order
     * @return int
     */
    public function getOrder() : int
    {
        return $this->order;
    }
}
