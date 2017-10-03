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
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Traits\ListItems;

/**
 * Class to manipulate account rated
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Rated
{
    use ListItems;

    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;
    /**
     * Account id
     * @var int
     */
    protected $account_id;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param Auth $auth
     * @param int $account_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, Auth $auth, int $account_id, array $options = array())
    {

    }

    public function getMovies()
    {

    }

    public function getTVShows()
    {

    }

    public function getTVEpisodes()
    {

    }

}
