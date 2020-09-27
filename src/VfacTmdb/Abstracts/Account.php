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

use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Traits\GeneratorTrait;

/**
 * abstract account class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
abstract class Account
{
    use GeneratorTrait;

    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;
    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;
    /**
     * Session_id string
     * @var string
     */
    protected $auth = null;
    /**
     * Account id
     * @var int
     */
    protected $account_id;
    /**
     * Configuration array
     * @var \stdClass
     */
    protected $conf = null;
    /**
     * Options
     * @var array
     */
    protected $options = [];

    /**
     * Page number
     * @var int
     */
    public $page = 1;
    /**
     * Total pages
     * @var int
     */
    public $total_pages = 1;
    /**
     * Total results
     * @var int
     */
    public $total_results = 0;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param string $session_id
     * @param int $account_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, string $session_id, int $account_id, array $options = array())
    {
        $this->tmdb            = $tmdb;
        $options['session_id'] = $session_id;
        $this->logger          = $tmdb->getLogger();
        $this->options         = $options;
        $this->account_id      = $account_id;
        // Configuration
        $this->conf            = $tmdb->getConfiguration();
        $this->setGeneratorTrait($tmdb);
    }

    /**
     * Add or remove item in list
     * @param string $list_type  Type of list (possible value : favorite / watchlist)
     * @param string $media_type type of media (movie / tv)
     * @param int    $media_id   media_id
     * @param bool   $add        add or remove item in list
     */
    protected function setListItem(string $list_type, string $media_type, int $media_id, bool $add)
    {
        try {
            $params               = [];
            $params['media_type'] = $media_type;
            $params['media_id']   = $media_id;
            $params[$list_type]   = $add;

            $this->tmdb->postRequest('account/' . $this->account_id . '/' . $list_type, $this->options, $params);

            return $this;
        } catch (TmdbException $e) {
            throw $e;
        }
    }

    /**
     * Get account list items
     * @param  string $list_type    type of list (possible value : favorite, rated, watchlist)
     * @param  string $item         item name, possible value : movies , tv , tv/episodes
     * @param  string $result_class class for the results
     * @return \Generator
     */
    protected function getAccountListItems(string $list_type, string $item, string $result_class) : \Generator
    {
        $options = [];
        $this->tmdb->checkOptionSessionId($this->options, $options);
        $this->tmdb->checkOptionLanguage($this->options, $options);
        $this->tmdb->checkOptionSortBy($this->options, $options);
        $this->tmdb->checkOptionPage($this->options, $options);

        $response = $this->tmdb->getRequest('account/' . $this->account_id . '/' . $list_type . '/' . $item, $options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, $result_class);
    }

    /**
     * Get page from result search
     * @return int
     */
    public function getPage() : int
    {
        return $this->page;
    }

    /**
     * Get total page from result search
     * @return int
     */
    public function getTotalPages() : int
    {
        return $this->total_pages;
    }

    /**
     * Get total results from search
     * @return int
     */
    public function getTotalResults() : int
    {
        return $this->total_results;
    }
}
