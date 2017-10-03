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
use vfalies\tmdb\Interfaces\AuthInterface;
use vfalies\tmdb\Results;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Traits\ListItems;

/**
 * Class to manipulate account favorite
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Favorite
{

    use ListItems;

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
        if (empty($auth->session_id))
        {
            throw new ServerErrorException('No account session found');
        }
        $this->auth       = $auth;
        $this->account_id = $account_id;
        $this->options    = $this->tmdb->checkOptions($options);
    }

    /**
     * Get account favorite movies
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        return $this->getAccountItems('movies', Results\Movie::class);
    }

    /**
     * Get account favorite tvshows
     * @return \Generator|Results\TVShow
     */
    public function getTVShows() : \Generator
    {
        return $this->getAccountItems('tv', Results\TVShow::class);
    }

    public function markAsFavorite()
    {

    }

    /**
     * Get account favorite items
     * @param  string $item         item name, possible value : movies / tv
     * @param  string $result_class class for the results
     * @return \Generator
     */
    private function getAccountItems(string $item, string $result_class)
    {
        $response = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/account/'.$this->account_id.'/favorite/'.$item, null, $this->options);

        $this->page          = (int) $response->page;
        $this->total_pages   = (int) $response->total_pages;
        $this->total_results = (int) $response->total_results;

        return $this->searchItemGenerator($response->results, $result_class);
    }

    /**
     * Search Item generator method
     * @param array $results
     * @param string $class
     */
    private function searchItemGenerator(array $results, $class)
    {
        $this->logger->debug('Starting search item generator');
        foreach ($results as $result)
        {
            $element = new $class($this->tmdb, $result);

            yield $element;
        }
    }
}
