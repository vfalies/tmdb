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

use VfacTmdb\Exceptions\NotFoundException;
use VfacTmdb\Exceptions\IncorrectParamException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Interfaces\AuthInterface;
use VfacTmdb\Exceptions\InvalidResponseException;

/**
* Auth class
* @package Tmdb
* @author Vincent Faliès <vincent@vfac.fr>
* @copyright Copyright (c) 2017
 */
class Auth implements AuthInterface
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
    protected $logger = null;
    /**
     * Request token
     * @var string
     */
    private $request_token = null;
    /**
     * Session Id
     * @var string
     */
    private $session_id = null;

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
     * Connect and valid request token
     * @param string $request_token
     * @param  string|null $redirect_url Redirection url after connection (optional)
     * @return bool
     */
    public function connect(string $request_token, ?string $redirect_url = null) : bool
    {
        $url = "https://www.themoviedb.org/authenticate/$request_token";
        if (!is_null($redirect_url)) {
            if (!filter_var($redirect_url, FILTER_VALIDATE_URL)) {
                throw new IncorrectParamException('Invalid redirect Url');
            }
            $url .= "?redirect_to=$redirect_url";
        }
        header("Location: $url");
        return true;
    }

    /**
     * Get a new request token
     * @return string
     */
    public function getRequestToken() : string
    {
        $data = $this->tmdb->getRequest('authentication/token/new', []);

        if (!isset($data->success) || $data->success != 'true' || !isset($data->request_token)) {
            throw new InvalidResponseException("Getting request token failed");
        }
        $this->request_token = $data->request_token;

        return $this->request_token;
    }

    /**
     * Create a new session Auth
     * @param string $request_token
     * @return string
     */
    public function createSession(string $request_token) : string
    {
        $data = $this->tmdb->getRequest('authentication/session/new', ['request_token' => $request_token]);

        if (!isset($data->success) || $data->success != 'true' || !isset($data->session_id)) {
            throw new InvalidResponseException("Creating session failed");
        }
        $this->session_id = $data->session_id;
        return $this->session_id;
    }

    /**
     * Magical getter
     * @param  string $name Name of the variable to get
     * @return mixed       Value of the variable getted
     */
    public function __get(string $name)
    {
        switch ($name) {
            case 'request_token':
          case 'session_id':
              return $this->$name;
            default:
              throw new NotFoundException();
        }
    }
}
