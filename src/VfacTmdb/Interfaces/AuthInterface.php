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


namespace VfacTmdb\Interfaces;

/**
 * Interface for Auth type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface AuthInterface
{
    /**
     * Connect and valid request token
     * @param string $request_token
     * @param  string|null $redirect_url Redirection url after connection (optional)
     * @return bool
     */
    public function connect(string $request_token, ?string $redirect_url = null) : bool;

    /**
     * Get a new request token
     * @return string
     */
    public function getRequestToken() : string;

    /**
     * Create a new session Auth
     * @param string $request_token
     * @return string
     */
    public function createSession(string $request_token) : string;
}
