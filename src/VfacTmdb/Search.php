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


namespace VfacTmdb;

use VfacTmdb\Exceptions\IncorrectParamException;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Traits\ListItems;
use VfacTmdb\Traits\GeneratorTrait;

/**
 * Search class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Search
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
     * Search specify item
     * @param string $item item to search : movie / tv / collection
     * @param string $query Query string to search like a $item
     * @param array $options Array of options for the request
     * @param string $result_class class name of the wanted result
     * @return \Generator
     * @throws TmdbException
     */
    private function searchItem(string $item, string $query, array $options, string $result_class) : \Generator
    {
        try {
            $this->logger->debug('Starting search item', array('item' => $item, 'query' => $query, 'options' => $options, 'result_class' => $result_class));
            $query = trim($query);
            if (empty($query)) {
                $this->logger->error('Query param cannot be empty', array('item' => $item, 'query' => $query, 'options' => $options, 'result_class' => $result_class));
                throw new IncorrectParamException;
            }
            $options['query'] = $query;
            $params           = $this->checkSearchItemOption($options);

            $response         = $this->tmdb->getRequest('search/' . $item, $params);

            $this->page          = (int) $response->page;
            $this->total_pages   = (int) $response->total_pages;
            $this->total_results = (int) $response->total_results;

            return $this->searchItemGenerator($response->results, $result_class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Check search item api option
     * @param array $options
     * @return array
     */
    private function checkSearchItemOption(array $options) : array
    {
        $params = [];
        $this->tmdb->checkOptionQuery($options, $params);
        $this->tmdb->checkOptionPage($options, $params);
        $this->tmdb->checkOptionLanguage($options, $params);
        $this->tmdb->checkOptionIncludeAdult($options, $params);
        $this->tmdb->checkOptionYear($options, $params);

        return $params;
    }

    /**
     * Search a movie
     * @param string $query Query string to search like a movie
     * @param array $options Array of options for the search
     * @return \Generator|Results\Movie
     * @throws TmdbException
     */
    public function movie(string $query, array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting search movie', array('query' => $query, 'options' => $options));
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
    public function tvshow(string $query, array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting search tv show', array('query' => $query, 'options' => $options));
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
    public function collection(string $query, array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting search collection', array('query' => $query, 'options' => $options));
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
    public function people(string $query, array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting search people', array('query' => $query, 'options' => $options));
            return $this->searchItem('person', $query, $options, Results\People::class);
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
    public function company(string $query, array $options = array()) : \Generator
    {
        try {
            $this->logger->debug('Starting search company', array('query' => $query, 'options' => $options));
            return $this->searchItem('company', $query, $options, Results\Company::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }
}
