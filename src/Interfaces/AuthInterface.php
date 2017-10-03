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


namespace vfalies\tmdb\Interfaces;

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
     * @param  string|null $redirect_url Redirection url after connection (optional)
     * @return bool
     */
    public function connect(?string $redirect_url = null) : bool;

    /**
     * Create a new session Auth
     * @return void
     */
    public function createSession() : void;
}
