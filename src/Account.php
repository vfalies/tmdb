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

use vfalies\tmdb\Account\Rated;
use vfalies\tmdb\Account\WatchList;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Account\Favorite;

use vfalies\tmdb\Interfaces\AuthInterface;

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
     * @var \vfalies\tmdb\Interfaces\AuthInterface
     */
    private $auth = null;
    /**
     * Data
     * @var \stdClass
     */
    private $data = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param AuthInterface $auth
     */
    public function __construct(TmdbInterface $tmdb, AuthInterface $auth)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
        if (empty($auth->session_id)) {
            throw new ServerErrorException('No account session found');
        }
        $this->auth         = $auth;

        // Get details account
        $this->data   = $this->tmdb->getRequest('/account', null, array('session_id' => $this->auth->session_id));
    }

    /**
     * Get account favorite elements
     * @param array $options
     * @return Favorite
     */
    public function getFavorite(array $options = array()) : Favorite
    {
        $this->logger->debug('Starting getting account favorite elements');
        $favorite = new Favorite($this->tmdb, $this->auth, $options);

        return $favorite;
    }

    /**
     * Get account rated elements
     * @param array $options
     * @return Rated
     */
    public function getRated(array $options = array()) : Rated
    {
        $this->logger->debug('Starting getting account rated elements');
        $rated = new Rated($this->tmdb, $this->auth, $options);

        return $rated;
    }

    /**
     * Get account watchlist elements
     * @param array $options
     * @return WatchList
     */
    public function getWatchList(array $options = array()) : WatchList
    {
        $this->logger->debug('Starting getting account watch list elements');
        $watchlist = new WatchList($this->tmdb, $this->auth, $options);

        return $watchlist;
    }

    /**
     * Get account id
     * @return int account id
     */
    public function getId() : int
    {
        if (isset($this->data->id)) {
            return $this->data->id;
        }
    }

    /**
     * Get account language
     * @return string language code in standard ISO 639_1
     */
    public function getLanguage() : string
    {
        if (isset($this->data->iso_639_1)) {
            return $this->data->iso_639_1;
        }
    }

    /**
     * Get country code
     * @return string country code in standard ISO 3166_1
     */
    public function getCountry() : string
    {
        if (isset($this->data->iso_3166_1)) {
            return $this->data->iso_3166_1;
        }
    }

    /**
     * Get account name
     * @return string account name
     */
    public function getName() : string
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
    }

    /**
     * Get account username
     * @return string account username
     */
    public function getUsername() : string
    {
        if (isset($this->data->username)) {
            return $this->data->username;
        }
    }

    /**
     * Get Gravatar hash
     * @return string gravatar hash
     */
    public function getGravatarHash() : string
    {
        if (isset($this->data->avatar->gravatar->hash)) {
            return $this->data->avatar->gravatar->hash;
        }
    }

    /**
     * Get if account include adult content
     * @return bool
     */
    public function getIncludeAdult() : bool
    {
        if (isset($this->data->include_adult)) {
            return $this->data->include_adult;
        }
    }
}
