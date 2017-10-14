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

use VfacTmdb\Account\Rated;
use VfacTmdb\Account\WatchList;
use VfacTmdb\Exceptions\ServerErrorException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Account\Favorite;

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
     * Session id string
     * @var string
     */
    private $session_id = null;
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
     * Account Id
     * @var int
     */
    protected $account_id;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param string $session_id
     */
    public function __construct(TmdbInterface $tmdb, string $session_id)
    {
        $this->tmdb       = $tmdb;
        $this->logger     = $tmdb->getLogger();
        $this->conf       = $this->tmdb->getConfiguration();
        $this->session_id = $session_id;

        // Get details account
        $this->data       = $this->tmdb->getRequest('account', array('session_id' => $this->session_id));
        if (!isset($this->data->id)) {
            throw new ServerErrorException('Invalid response for details account');
        }
        $this->account_id = $this->data->id;
    }

    /**
     * Get an account list
     * @param  string $type    class name of the type of list (possible value : Favorite, Rated, WatchList)
     * @param  array  $options
     * @return mixed
     */
    private function getList(string $type, array $options = array())
    {
        $this->logger->debug("Starting getting account $type elements", array('options' => $options));
        $list = new $type($this->tmdb, $this->session_id, $this->account_id, $options);

        return $list;
    }

    /**
     * Get account favorite elements
     * @param array $options
     * @return Favorite
     */
    public function getFavorite(array $options = array()) : Favorite
    {
        return $this->getList(Favorite::class, $options);
    }

    /**
     * Get account rated elements
     * @param array $options
     * @return Rated
     */
    public function getRated(array $options = array()) : Rated
    {
        return $this->getList(Rated::class, $options);
    }

    /**
     * Get account watchlist elements
     * @param array $options
     * @return WatchList
     */
    public function getWatchList(array $options = array()) : WatchList
    {
        return $this->getList(WatchList::class, $options);
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
