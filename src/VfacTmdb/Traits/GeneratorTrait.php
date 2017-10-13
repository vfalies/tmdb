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

/**
 * Generator trait
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait GeneratorTrait
{
    /**
     * Item generator method
     * @param array $results
     * @param string $class
     */
    protected function searchItemGenerator(array $results, string $class)
    {
        $this->logger->debug('Starting search item generator', array('results' => $results, 'class' => $class));
        foreach ($results as $result) {
            $element = new $class($this->tmdb, $result);

            yield $element;
        }
    }
}
