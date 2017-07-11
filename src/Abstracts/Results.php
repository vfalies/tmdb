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


namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Interfaces\Results\ResultsInterface;

/**
 * Abstract results class
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
abstract class Results implements ResultsInterface
{
    /**
     * Properties to ignore in object control validation in constructor
     * @var array
     */
    protected $property_blacklist = ['property_blacklist', 'conf', 'data', 'logger', 'tmdb', 'params'];
    /**
     * Logger object
     * @var LoggerInterface
     */
    protected $logger             = null;
    /**
     * Configuration array
     * @var \stdClass
     */
    protected $conf               = null;
    /**
     * Tmdb object
     * @var \vfalies\tmdb\Tmdb
     */
    protected $tmdb               = null;
    /**
     * Data object
     * @var \stdClass
     */
    protected $data               = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws NotFoundException
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        $this->logger = $tmdb->logger;

        // Valid input object
        $properties = get_object_vars($this);
        foreach (array_keys($properties) as $property)
        {
            if ( ! in_array($property, $this->property_blacklist) && ! property_exists($result, $property))
            {
                throw new NotFoundException($property);
            }
        }

        // Configuration
        $this->conf = $tmdb->getConfiguration();
        $this->data = $result;
        $this->tmdb = $tmdb;
    }

}
