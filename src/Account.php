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

use vfalies\tmdb\Exceptions\TmdbException;
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
   * Account connexion
   * @param string $redirect_to URL redirect after authentification
   * @return void
   */
  public function connect(string $redirect_to) : void
  {
      try {
          $token = $this->getTemporaryRequestToken();

          header("Location: https://www.themoviedb.org/authenticate/$token?redirect_to=$redirect_to", 301);
          exit();
      } catch (TmdbException $e) {
        throw $e;
      }
  }

  /**
   * Get temporary request token
   * @return string temporary request token
   * @throws InvalidResponseException
   */
  private function getTemporaryRequestToken()
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/token/new', null, []);

      if (!isset($data->success) || $data->success != 'true')
      {
          throw new InvalidResponseException();
      }
     return $data->request_token;
  }

  /**
   * Create an user session id
   * @param  string $request_token TMDB request token, return after Account::connect() call
   * @return string                Session ID
   */
  public function createSession(string $request_token) : string
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/token/new', null, ['request_token' => $request_token]);

      if (!isset($data->success) || $data->success != 'true')
      {
          throw new InvalidResponseException();
      }
      return $data->session_id;
  }
}
