<?php

namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotFoundException;

abstract class Results extends Element implements \vfalies\tmdb\Interfaces\ResultsInterface
{

    protected $id                 = null;
    protected $poster_path        = null;
    protected $backdrop_path      = null;
    protected $property_blacklist = ['property_blacklist', 'conf', 'data'];

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws NotFoundException
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        // Valid input object
        $properties = get_object_vars($this);
        foreach (array_keys($properties) as $property)
        {
            if ( ! in_array($property, $this->property_blacklist) && !property_exists($result, $property))
            {
                throw new NotFoundException;
            }
        }

        // Configuration
        $this->conf = $tmdb->getConfiguration();
        $this->data = $result;
    }

}
