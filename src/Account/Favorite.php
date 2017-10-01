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


namespace vfalies\tmdb\Account;
use vfalies\tmdb\Auth;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate account favorite
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Favorite
{
    /**
     * Configuration
     * @var \stdClass
     */
    protected $conf = null;
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;
    /**
     * Auth object
     * @var Auth
     */
    protected $auth = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param Auth $auth
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, Auth $auth, array $options = array())
    {
        if (empty($auth->session_id))
        {
            throw new ServerErrorException('No account session found');
        }
        $this->auth = $auth;
    }

    public function getMovies()
    {

    }

    public function getTVShows()
    {

    }

    public function markAsFavorite()
    {

    }
}
