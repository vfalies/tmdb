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


namespace VfacTmdb\Abstracts;

use VfacTmdb\Exceptions\NotFoundException;
use VfacTmdb\Interfaces\Results\ResultsInterface;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Abstract results class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
abstract class Results implements ResultsInterface
{
    /**
     * Properties to ignore in object control validation in constructor
     * @var array
     */
    protected $property_blacklist = ['property_blacklist', 'conf', 'data', 'logger', 'tmdb', 'params', 'element_trait', 'tvepisode_trait'];
    /**
     * Logger object
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;
    /**
     * Configuration array
     * @var \stdClass
     */
    protected $conf = null;
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;
    /**
     * Data object
     * @var \stdClass
     */
    protected $data = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     * @throws NotFoundException
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        $this->logger = $tmdb->getLogger();

        // Valid input object
        $properties = get_object_vars($this);
        foreach (array_keys($properties) as $property) {
            if (!in_array($property, $this->property_blacklist) && !property_exists($result, $property)) {
                throw new NotFoundException($property);
            }
        }

        // Configuration
        $this->conf = $tmdb->getConfiguration();
        $this->data = $result;
        $this->tmdb = $tmdb;
    }
}
