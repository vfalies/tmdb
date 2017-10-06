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


namespace vfalies\tmdb;

use vfalies\tmdb\Exceptions\IncorrectParamException;
use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Traits\ListItems;

/**
 * Search class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Search
{
    use ListItems;

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
    }

    /**
     * Search specify item
     * @param string $item item to search : movie / tv / collection
     * @param string $query Query string to search like a $item
     * @param array $options Array of options for the request
     * @param string $result_class class name of the wanted result
     * @return \Generator
     * @throws TmdbException
     */
    private function searchItem($item, $query, array $options, $result_class)
    {
        try {
            $this->logger->debug('Starting search item');
            $query = trim($query);
            if (empty($query)) {
                $this->logger->error('Query param cannot be empty', array('item' => $item, 'query' => $query, 'options' => $options, 'result_class' => $result_class));
                throw new IncorrectParamException;
            }
            $params   = $this->tmdb->checkOptions($options);
            $response = $this->tmdb->getRequest('search/' . $item, $query, $params);

            $this->page          = (int) $response->page;
            $this->total_pages   = (int) $response->total_pages;
            $this->total_results = (int) $response->total_results;

            return $this->searchItemGenerator($response->results, $result_class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Search Item generator method
     * @param array $results
     * @param string $class
     */
    private function searchItemGenerator(array $results, $class)
    {
        $this->logger->debug('Starting search item generator');
        foreach ($results as $result) {
            $element = new $class($this->tmdb, $result);

            yield $element;
        }
    }

    /**
     * Search a movie
     * @param string $query Query string to search like a movie
     * @param array $options Array of options for the search
     * @return \Generator|Results\Movie
     * @throws TmdbException
     */
    public function movie($query, array $options = array())
    {
        try {
            $this->logger->debug('Starting search movie');
            return $this->searchItem('movie', $query, $options, Results\Movie::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Search a TV Show
     * @param string $query Query string to search like a TV Show
     * @param array $options Array of options for the request
     * @return \Generator|Results\TVShow
     * @throws TmdbException
     */
    public function tvshow($query, array $options = array())
    {
        try {
            $this->logger->debug('Starting search tv show');
            return $this->searchItem('tv', $query, $options, Results\TVShow::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Search a collection
     * @param string $query Query string to search like a collection
     * @param array $options Array of option for the request
     * @return \Generator|Results\Collection
     * @throws TmdbException
     */
    public function collection($query, array $options = array())
    {
        try {
            $this->logger->debug('Starting search collection');
            return $this->searchItem('collection', $query, $options, Results\Collection::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Search a people
     * @param string $query Query string to search like a people
     * @param array $options Array of option for the request
     * @return \Generator|Results\People
     * @throws TmdbException
     */
    public function people($query, array $options = array())
    {
        try {
            $this->logger->debug('Starting search people');
            return $this->searchItem('people', $query, $options, Results\People::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Search a company
     * @param string $query Query string to search like a company
     * @param array $options Array of option for the request
     * @return \Generator|Results\Company
     * @throws TmdbException
     */
    public function company($query, array $options = array())
    {
        try {
            $this->logger->debug('Starting search company');
            return $this->searchItem('people', $query, $options, Results\Company::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
