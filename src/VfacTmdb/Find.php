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
 * @copyright Copyright (c) 2020
 */


namespace VfacTmdb;

use VfacTmdb\Exceptions\IncorrectParamException;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Traits\ListItems;
use VfacTmdb\Traits\GeneratorTrait;
use VfacTmdb\Results;

/**
 * Find class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2020
 */
class Find
{
    use ListItems;
    use GeneratorTrait;

    /**
     * Tmdb object
     * @var TmdbInterface
     */
    private $tmdb = null;
    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
        $this->setGeneratorTrait($tmdb);
    }

    /**
     * Find specify item
     * @param string $item item to find : {external_id}
     * @param string $query Query string to search like a $item
     * @param array $options Array of options for the request
     * @param string $result_class class name of the wanted result
     * @return Results\Find
     * @throws TmdbException
     */
    private function findItem(string $item, string $query, array $options, string $result_class) : Results\Find
    {
        try {
            $this->logger->debug('Starting find item', array('item' => $item, 'query' => $query, 'options' => $options, 'result_class' => $result_class));
            $query = trim($query);
            $options['query'] = $query;
            $params           = $this->checkSearchItemOption($options);

            $response         = $this->tmdb->getRequest('find/' . $item, $params);
            if (!$response instanceof \stdClass) {
                throw new TmdbException('Incorrect find response');
            }

            return new Results\Find($this->tmdb, $response);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Check search item api option
     * @param array $options
     * @return array
     */
    private function checkSearchItemOption(array $options) : array
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($options, $params);
        $this->tmdb->checkOptionExternalSource($options, $params);

        return $params;
    }

    /**
     * Find by external id
     * @param string $external_id Query string to search like a movie
     * @param string $external_source Source of the external_id
     *               allowed values: imdb_id, freebase_mid, freebase_id, tvdb_id, tvrage_id, facebook_id, twitter_id, instagram_id
     * @param array $options Array of options for the search
     * @return Results\Find
     * @throws TmdbException
     */
    private function external(string $external_id, string $external_source, array $options = array()) : Results\Find
    {
        try {
            $this->logger->debug('Starting find by external id', array('external_id' => $external_id, 'options' => $options));
            $options['external_source'] = $external_source;
            return $this->findItem($external_id, '', $options, Results\Movie::class);
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Find by external id on IMDB
     *
     * @param string $external_id
     * @param array $options
     * @return Results\Find
     */
    public function imdb(string $external_id, array $options = array()) : Results\Find
    {
        return $this->external($external_id, 'imdb_id', $options);
    }

    /**
     * Find by external id on Freebase
     *
     * @param string $external_id
     * @param array $options
     * @deprecated
     * @return Results\Find
     */
    // public function freebase(string $external_id, array $options = array()) : Results\Find
    // {
    //     return $this->external($external_id, 'freebase_id', $options);
    // }

    /**
     * Find by external id on TVdb
     *
     * @param string $external_id
     * @param array $options
     * @return Results\Find
     */
    public function tvdb(string $external_id, array $options = array()) : Results\Find
    {
        return $this->external($external_id, 'tvdb_id', $options);
    }

    /**
     * Find by external id on TVRage
     *
     * @param string $external_id
     * @param array $options
     * @return Results\Find
     */
    public function tvrage(string $external_id, array $options = array()) : Results\Find
    {
        return $this->external($external_id, 'tvrage_id', $options);
    }

    /**
     * Find by external id on Facebook
     *
     * @param string $external_id
     * @param array $options
     * @return Results\Find
     */
    public function facebook(string $external_id, array $options = array()) : Results\Find
    {
        return $this->external($external_id, 'facebook_id', $options);
    }

    /**
     * Find by external id on Twitter
     *
     * @param string $external_id
     * @param array $options
     * @return Results\Find
     */
    public function twitter(string $external_id, array $options = array()) : Results\Find
    {
        return $this->external($external_id, 'twitter_id', $options);
    }

    /**
     * Instagram
     *
     * @param string $external_id
     * @param array $options
     * @return Results\Find
     */
    public function instagram(string $external_id, array $options = array()) : Results\Find
    {
        return $this->external($external_id, 'instagram_id', $options);
    }
}
