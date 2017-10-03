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

use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\IncorrectParamException;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Interfaces\AuthInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\InvalidResponseException;

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
  private $logger = null;
  /**
   * Request token
   * @var string
   */
  private $request_token = null;
  /**
   * Expiration date of request token
   * @var \DateTime
   */
  private $request_token_expiration = null;
  /**
   * Session Id
   * @var string
   */
  private $session_id  = null;

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
   * @param  string|null $redirect_url Redirection url after connection (optional)
   * @return bool
   */
  public function connect(?string $redirect_url = null) : bool
  {
      $this->getRequestToken();
      $url = "https://www.themoviedb.org/authenticate/$this->request_token";
      if (!is_null($redirect_url))
      {
          if (!filter_var($redirect_url, FILTER_VALIDATE_URL))
          {
              throw new IncorrectParamException('Invalid redirect Url');
          }
          $url .= "?redirect_to=$redirect_url";
      }
      header("Location: $url");
      return true;
  }

  /**
   * Get a new request token
   * @return void
   */
  private function getRequestToken() : void
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/token/new', null, []);

      if (!isset($data->success) || $data->success != 'true' || !isset($data->request_token))
      {
          throw new InvalidResponseException("Getting request token failed");
      }
     $this->request_token            = $data->request_token;
     $this->request_token_expiration = \DateTime::createFromFormat('Y-m-d H:i:s e', $data->expires_at);
  }

  /**
   * Create a new session Auth
   * @return void
   */
  public function createSession() : void
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/session/new', null, ['request_token' => $this->request_token]);

      if (!isset($data->success) || $data->success != 'true' || !isset($data->session_id))
      {
          throw new InvalidResponseException("Creating session failed");
      }
      $this->session_id = $data->session_id;
  }

  /**
   * Magical getter
   * @param  string $name Name of the variable to get
   * @return mixed        Value of the variable getted
   */
  public function __get(string $name)
  {
      switch ($name)
      {
          case 'request_token':
          case 'session_id':
              return $this->$name;
          default:
              throw new NotFoundException();
      }
  }
}
