<?php

namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Tmdb;

abstract class Results extends Element implements \vfalies\tmdb\Interfaces\Results\ResultsInterface
{

    protected $id                 = null;    
    protected $property_blacklist = ['property_blacklist', 'conf', 'data'];

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws \Exception
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        // Valid input object
        $properties = get_object_vars($this);
        foreach (array_keys($properties) as $property)
        {
            if ( ! in_array($property, $this->property_blacklist) && !property_exists($result, $property))
            {
                throw new \Exception('Incorrect input for ' . __CLASS__ . ' object. Property "' . $property . '" not found');
            }
        }

        // Configuration
        $this->conf = $tmdb->getConfiguration();
        $this->data = $result;
    }

}
