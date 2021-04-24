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

namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Interfaces\Items\PeopleInterface;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Items\PeopleMovieCredit;
use VfacTmdb\Items\PeopleTVShowCredit;
use VfacTmdb\Results;

/**
 * People class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class People extends Item implements PeopleInterface
{
    use ElementTrait;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $people_id
     * @param array $options
     * @throws TmdbException
     */
    public function __construct(TmdbInterface $tmdb, int $people_id, array $options = array())
    {
        parent::__construct($tmdb, $people_id, $options, 'person');

        $this->setElementTrait($this->data);
    }

    /**
     * Adult
     * @return bool
     */
    public function getAdult() : bool
    {
        if (isset($this->data->adult)) {
            return $this->data->adult;
        }
        return false;
    }

    /**
     * Alse Known as
     * @return array
     */
    public function getAlsoKnownAs() : array
    {
        if (isset($this->data->also_known_as)) {
            return $this->data->also_known_as;
        }
        return [];
    }

    /**
     * Biography
     * @return string
     */
    public function getBiography() : string
    {
        if (isset($this->data->biography)) {
            return $this->data->biography;
        }
        return '';
    }

    /**
     * Birthday
     * @return string
     */
    public function getBirthday() : string
    {
        if (isset($this->data->birthday)) {
            return $this->data->birthday;
        }
        return '';
    }

    /**
     * Deathday
     * @return string
     */
    public function getDeathday() : string
    {
        if (isset($this->data->deathday)) {
            return $this->data->deathday;
        }
        return '';
    }

    /**
     * Gender
     * @return int
     */
    public function getGender() : int
    {
        if (isset($this->data->gender)) {
            return $this->data->gender;
        }
        return 0;
    }

    /**
     * Homepage
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
     * Id
     * @return int
     */
    public function getId() : int
    {
        if (isset($this->data->id)) {
            return $this->data->id;
        }
        return 0;
    }

    /**
     * Imdb Id
     * @return string
     */
    public function getImdbId() : string
    {
        if (isset($this->data->imdb_id)) {
            return $this->data->imdb_id;
        }
        return '';
    }

    /**
     * Name
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
     * Place of birth
     * @return string
     */
    public function getPlaceOfBirth() : string
    {
        if (isset($this->data->place_of_birth)) {
            return $this->data->place_of_birth;
        }
        return '';
    }

    /**
     * Popularity
     * @return float
     */
    public function getPopularity() : float
    {
        if (isset($this->data->popularity)) {
            return $this->data->popularity;
        }
        return 0;
    }

    /**
     * Image profile path
     * @return string
     */
    public function getProfilePath() : string
    {
        if (isset($this->data->profile_path)) {
            return $this->data->profile_path;
        }
        return '';
    }

    /**
     * Images Profiles
     * @return \Generator|Results\Image
     */
    public function getProfiles() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('person/' . (int) $this->id . '/images', $params);

        foreach ($data->profiles as $b) {
            $image = new Results\Image($this->tmdb, $this->id, $b);
            yield $image;
        }
    }

    /**
     * Get movies cast
     * @return \Generator|Results\PeopleMovieCast
     */
    public function getMoviesCast() : \Generator
    {
        $credit = new PeopleMovieCredit($this->tmdb, $this->id);
        return $credit->getCast();
    }

    /**
     * Get movies crew
     * @return \Generator|Results\PeopleMovieCast
     */
    public function getMoviesCrew() : \Generator
    {
        $credit = new PeopleMovieCredit($this->tmdb, $this->id);
        return $credit->getCrew();
    }


    /**
     * Get TVShow cast
     * @return \Generator|Results\PeopleTVShowCast
     */
    public function getTVShowCast() : \Generator
    {
        $credit = new PeopleTVShowCredit($this->tmdb, $this->id);
        return $credit->getCast();
    }

    /**
     * Get TVShow crew
     * @return \Generator|Results\PeopleTVShowCast
     */
    public function getTVShowCrew() : \Generator
    {
        $credit = new PeopleTVShowCredit($this->tmdb, $this->id);
        return $credit->getCrew();
    }

    /**
     * Get the underlying ItemChanges object for this Item
     * @param array $options Array of options for the request
     * @return PeopleItemChanges
     */
    public function getItemChanges(array $options = array()) : PeopleItemChanges
    {
        return new PeopleItemChanges($this->tmdb, $this->id, $options);
    }

    /**
     * Get this Item's Changes
     * @param array $options Array of options for the request
     * @return \Generator
     */
    public function getChanges(array $options = array()) : \Generator
    {
        $changes = $this->getItemChanges($options);
        return $changes->getChanges();
    }
}
