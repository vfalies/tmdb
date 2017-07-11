<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\PeopleResultsInterface;
use vfalies\tmdb\Exceptions\NotYetImplementedException;

class People extends Results implements PeopleResultsInterface
{

    protected $adult        = null;
    protected $known_for    = null;
    protected $name         = null;
    protected $popularity   = null;
    protected $profile_path = null;
    protected $id           = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
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

    public function getId()
    {
        return (int) $this->id;
    }

    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * @codeCoverageIgnore
     * @throws NotYetImplementedException
     */
    public function getKnownFor()
    {
        throw new NotYetImplementedException;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPopularity()
    {
        return $this->popularity;
    }

    public function getProfilePath()
    {
        return $this->profile_path;
    }

}
