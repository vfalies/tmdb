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

namespace vfalies\tmdb\Catalogs;

use vfalies\tmdb\Interfaces\TmdbInterface;

use vfalies\tmdb\Exceptions\TmdbException;

/**
 * Class to get jobs list with department
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Jobs
{

    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Get job list
     * @param array $options
     * @return \Generator|\stdClass
     * @throws TmdbException
     */
    public function getList(array $options = array())
    {
        try {
            $params   = $this->tmdb->checkOptions($options);
            $response = $this->tmdb->getRequest('job/list', $params);

            $results = [];
            if (isset($response->jobs)) {
                foreach ($response->jobs as $j) {
                    $result             = new \stdClass();
                    $result->department = $j->department;
                    $result->jobs       = $j->job_list;

                    $results[] = $result;
                }
            }
        } catch (TmdbException $ex) {
            throw $ex;
        }
        return $this->genreItemGenerator($results);
    }

    /**
     * Genre Item generator method
     * @param array $results
     */
    private function genreItemGenerator(array $results)
    {
        foreach ($results as $result) {
            yield $result;
        }
    }
}
