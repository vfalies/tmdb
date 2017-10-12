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


namespace VfacTmdb;

use PHPUnit\Util\Configuration;
use VfacTmdb\Account\Rated;
use VfacTmdb\Account\WatchList;
use VfacTmdb\Exceptions\ServerErrorException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Account\Favorite;

use VfacTmdb\Interfaces\AuthInterface;

/**
 * Account class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Account
{
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    private $tmdb = null;
    /**
     * Logger object
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;
    /**
     * Auth object
     * @var \VfacTmdb\Interfaces\AuthInterface
     */
    private $auth = null;
    /**
     * Data
     * @var \stdClass
     */
    private $data = null;
    /**
     * Configuration
     * @var \stdClass
     */
    protected $conf;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param AuthInterface $auth
     */
    public function __construct(TmdbInterface $tmdb, AuthInterface $auth)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();

        if (trim($auth->session_id) == '') {
            throw new ServerErrorException('No account session found');
        }
        $this->auth = $auth;
        $this->conf = $this->tmdb->getConfiguration();

        // Get details account
        $this->data       = $this->tmdb->getRequest('account', array('session_id' => $this->auth->session_id));
        if (!isset($this->data->id)) {
            throw new ServerErrorException('Invalid response for details account');
        }
        $this->account_id = $this->data->id;
    }

    /**
     * Get account favorite elements
     * @param array $options
     * @return Favorite
     */
    public function getFavorite(array $options = array()) : Favorite
    {
        $this->logger->debug('Starting getting account favorite elements', array('options' => $options));
        $favorite = new Favorite($this->tmdb, $this->auth, $this->account_id, $options);

        return $favorite;
    }

    /**
     * Get account rated elements
     * @param array $options
     * @return Rated
     */
    public function getRated(array $options = array()) : Rated
    {
        $this->logger->debug('Starting getting account rated elements', array('options' => $options));
        $rated = new Rated($this->tmdb, $this->auth, $this->account_id, $options);

        return $rated;
    }

    /**
     * Get account watchlist elements
     * @param array $options
     * @return WatchList
     */
    public function getWatchList(array $options = array()) : WatchList
    {
        $this->logger->debug('Starting getting account watch list elements', array('options' => $options));
        $watchlist = new WatchList($this->tmdb, $this->auth, $this->account_id, $options);

        return $watchlist;
    }

    /**
     * Get account id
     * @return int account id
     */
    public function getId() : int
    {
        return $this->data->id;
    }

    /**
     * Get account language
     * @return string language code in standard ISO 639_1
     */
    public function getLanguage() : string
    {
        return $this->data->iso_639_1;
    }

    /**
     * Get country code
     * @return string country code in standard ISO 3166_1
     */
    public function getCountry() : string
    {
        return $this->data->iso_3166_1;
    }

    /**
     * Get account name
     * @return string account name
     */
    public function getName() : string
    {
        return $this->data->name;
    }

    /**
     * Get account username
     * @return string account username
     */
    public function getUsername() : string
    {
        return $this->data->username;
    }

    /**
     * Get Gravatar hash
     * @return string gravatar hash
     */
    public function getGravatarHash() : string
    {
        return $this->data->avatar->gravatar->hash;
    }

    /**
     * Get if account include adult content
     * @return bool
     */
    public function getIncludeAdult() : bool
    {
        return $this->data->include_adult;
    }
}