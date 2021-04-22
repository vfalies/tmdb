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
 * @copyright Copyright (c) 2017-2020
 */

namespace VfacTmdb;

use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Traits\ListItems;
use VfacTmdb\Traits\GeneratorTrait;

/**
 * Change class
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2017-2020
 */
class Change
{
    use ListItems;
    use GeneratorTrait;

    /**
     * Tmdb object
     * @var TmdbInterface
     */
    private $tmdb = null;
    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
        $this->setGeneratorTrait($tmdb);
    }

    /**
     * Get changes for type
     * @param string $type Type to get changes for: movie / tv / person
     * @param array $options Array of options for the request
     * @return \Generator
     * @throws TmdbException
     */
    private function typeChanges(string $type, array $options) : \Generator
    {
        try {
            $this->logger->debug('Starting changes for type', array('type' => $type, 'options' => $options));

            $params           = $this->checkTypeChangesOptions($options);

            $response         = $this->tmdb->getRequest($type . '/changes', $params);

            $this->page          = (int) $response->page;
            $this->total_pages   = (int) $response->total_pages;
            $this->total_results = (int) $response->total_results;

            return $this->typeChangeGenerator($response->results);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Check the type changes API options
     * @param array $options
     * @return array
     */
    private function checkTypeChangesOptions(array $options) : array
    {
        $params = [];
        $this->tmdb->checkOptionPage($options, $params);
        $this->tmdb->checkOptionDateRange($options, $params);

        return $params;
    }

    /**
     * Get changed Movies
     * @param array $options Array of options for the request
     * @return \Generator|Results\Change
     * @throws TmdbException
     */
    public function movie(array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting movie changes', array('options' => $options));
            return $this->typeChanges('movie', $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Get changed TVShows
     * @param array $options Array of options for the request
     * @return \Generator|Results\Change
     * @throws TmdbException
     */
    public function tvshow(array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting TVShow changes', array('options' => $options));
            return $this->typeChanges('tv', $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Get changed People
     * @param array $options Array of options for the request
     * @return \Generator|Results\Change
     * @throws TmdbException
     */
    public function person(array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting person changes', array('options' => $options));
            return $this->typeChanges('person', $options);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
