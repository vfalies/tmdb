<?php

namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\PeopleInterface;

class People extends Item implements PeopleInterface
{

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $people_id
     * @param array $options
     * @throws Exception
     */
    public function __construct(Tmdb $tmdb, int $people_id, array $options = array())
    {
        parent::__construct($tmdb, $people_id, $options, 'people');
    }

    public function getAdult(): bool
    {
        if (isset($this->data->adult))
        {
            return $this->data->adult;
        }
        return false;
    }

    public function getAlsoKnownAs(): array
    {
        if (isset($this->data->also_known_as))
        {
            return $this->data->also_known_as;
        }
        return [];
    }

    public function getBiography(): string
    {
        if (isset($this->data->biography))
        {
            return $this->data->biography;
        }
        return '';
    }

    public function getBirthday(): stringtitle
    {
        if (isset($this->data->birthday))
        {
            return $this->data->birthday;
        }
        return '';
    }

    public function getDeathday(): string
    {
        if (isset($this->data->deathday))
        {
            return $this->data->deathday;
        }
        return '';
    }

    public function getGender(): int
    {
        if (isset($this->data->gender))
        {
            return $this->data->gender;
        }
        return 0;
    }

    public function getHomepage(): string
    {
        if (isset($this->data->homepage))
        {
            return $this->data->homepage;
        }
        return '';
    }

    public function getId(): int
    {
        if (isset($this->data->id))
        {
            return $this->data->id;
        }
        return 0;
    }

    public function getImdbId(): int
    {
        if (isset($this->data->imdb_id))
        {
            return $this->data->imdb_id;
        }
        return 0;
    }

    public function getName(): string
    {
        if (isset($this->data->name))
        {
            return $this->data->name;
        }
        return '';
    }

    public function getPlaceOfBirth(): string
    {
        if (isset($this->data->place_of_birth))
        {
            return $this->data->place_of_birth;
        }
        return '';
    }

    public function getPopularity(): float
    {
        if (isset($this->data->popularity))
        {
            return $this->data->popularity;
        }
        return 0;
    }

    public function getProfilePath(): string
    {
        if (isset($this->data->profile_path))
        {
            return $this->data->profile_path;
        }
        return '';
    }

}
