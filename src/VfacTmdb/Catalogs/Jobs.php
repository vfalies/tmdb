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

namespace VfacTmdb\Catalogs;

use VfacTmdb\Interfaces\TmdbInterface;

use VfacTmdb\Exceptions\TmdbException;

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
     * @return \Generator|\stdClass
     * @throws TmdbException
     */
    public function getList() : \Generator
    {
        try {
            $response = $this->tmdb->getRequest('job/list');

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
     * @return \Generator
     */
    private function genreItemGenerator(array $results) : \Generator
    {
        foreach ($results as $result) {
            yield $result;
        }
    }
}
