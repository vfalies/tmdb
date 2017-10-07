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
use vfalies\tmdb\Interfaces\Results\PeopleResultsInterface;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * People class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class People extends Results implements PeopleResultsInterface
{
    /**
     * Adult
     * @var string
     */
    protected $adult = null;
    /**
     * People known for
     * @var array
     */
    protected $known_for = null;
    /**
     * People name
     * @var string
     */
    protected $name = null;
    /**
     * Popularity
     * @var int
     */
    protected $popularity = null;
    /**
     * Image profile path
     * @var string
     */
    protected $profile_path = null;
    /**
     * Id
     * @var int
     */
    protected $id = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id           = $this->data->id;
        $this->adult        = $this->data->adult;
        $this->known_for    = $this->data->known_for;
        $this->name         = $this->data->name;
        $this->popularity   = $this->data->popularity;
        $this->profile_path = $this->data->profile_path;
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
     * Get Adult
     * @return string
     */
    public function getAdult() : string
    {
        return $this->adult;
    }

    /**
     * People name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * People Popularity
     * @return string
     */
    public function getPopularity() : string
    {
        return $this->popularity;
    }

    /**
     * Image profile path
     * @return string
     */
    public function getProfilePath() : string
    {
        return $this->profile_path;
    }
}
