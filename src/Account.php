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
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\InvalidResponseException;

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
   * Constructor
   * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
   */
  public function __construct(TmdbInterface $tmdb)
  {
      $this->tmdb   = $tmdb;
      $this->logger = $tmdb->getLogger();
  }

  /**
   * Connect and valid request token
   * @param  string $request_token Request token
   * @param  string|null $redirect_url Redirection url after connection (optional)
   * @return bool
   */
  public function connect(string $request_token, ?string $redirect_url = null) : bool
  {
      $url = "https://www.themoviedb.org/authenticate/$request_token";
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
   * @return string Request token
   */
  public function getRequestToken() : string
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/token/new', null, []);

      if (!isset($data->success) || $data->success != 'true' || !isset($data->request_token))
      {
          throw new InvalidResponseException("Getting request token failed");
      }
     return $data->request_token;
  }

  /**
   * Create a new session Account
   * @param  string $request_token Request token create by Account::getRequestToken() and validate by Account::connect()
   * @return string                Session token string
   */
  public function createSession(string $request_token) : string
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/session/new', null, ['request_token' => $request_token]);

      if (!isset($data->success) || $data->success != 'true' || !isset($data->session_id))
      {
          throw new InvalidResponseException("Creating session failed");
      }
      return $data->session_id;
  }
}
