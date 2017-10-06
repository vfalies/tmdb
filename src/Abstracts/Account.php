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


namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Interfaces\AuthInterface;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * abstract account class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
abstract class Account
{
  /**
   * Tmdb object
   * @var TmdbInterface
   */
  protected $tmdb = null;
  /**
   * Auth object
   * @var AuthInterface
   */
  protected $auth = null;
  /**
   * Account id
   * @var int
   */
  protected $account_id;
  /**
   * Options
   * @var array
   */
  protected $options = [];
  /**
   * Constructor
   * @param TmdbInterface $tmdb
   * @param AuthInterface $auth
   * @param int $account_id
   * @param array $options
   */
  public function __construct(TmdbInterface $tmdb, AuthInterface $auth, int $account_id, array $options = array())
  {
      if (empty($auth->session_id)) {
          throw new ServerErrorException('No account session found');
      }
      $this->tmdb       = $tmdb;
      $this->auth       = $auth;
      $this->account_id = $account_id;
      $this->options    = $this->tmdb->checkOptions($options);
  }
}