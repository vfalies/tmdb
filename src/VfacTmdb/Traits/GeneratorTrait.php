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

namespace VfacTmdb\Traits;

use VfacTmdb\Results\Change;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Generator trait
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait GeneratorTrait
{
    /**
     * GeneratorTrait object variable
     * @var \stdClass
     */
    protected $generator_trait;

    /**
     * Set GeneratorTrait variable
     * @param TmdbInterface $tmdb
     * @return void
     */
    protected function setGeneratorTrait(TmdbInterface $tmdb) : void
    {
        $this->generator_trait         = new \stdClass();
        $this->generator_trait->tmdb   = $tmdb;
        $this->generator_trait->logger = $tmdb->getLogger();
    }

    /**
     * Item generator method
     * @param array $results
     * @param string $class
     */
    protected function searchItemGenerator(array $results, string $class)
    {
        $this->generator_trait->logger->debug('Starting search item generator', array('results' => $results, 'class' => $class));
        foreach ($results as $result) {
            $element = new $class($this->generator_trait->tmdb, $result);

            yield $element;
        }
    }

    /**
     * Type change generator method
     * @param array $results
     * @author Steve Richter <steve@nerdbra.in>
     */
    protected function typeChangeGenerator(array $results)
    {
        $this->generator_trait->logger->debug('Starting type change generator', array('results' => $results));
        foreach ($results as $result) {
            $element = new Change($this->generator_trait->tmdb, $result);

            yield $element;
        }
    }
}
