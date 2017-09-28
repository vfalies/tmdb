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

  public function connect()
  {
      try {
          $token = $this->getRequestToken();
      } catch (TmdbException $e) {
        throw $e;
      }
  }

  private function getRequestToken()
  {
      $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/authentification/token/new', null, []);

      if (!isset($data->success) || $data->success != 'true')
      {
          throw new InvalidResponseException();
      }
     return $data->request_token;
  }
}
