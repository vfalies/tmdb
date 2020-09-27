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


namespace VfacTmdb\Factory\Builder;

use VfacTmdb\Interfaces\Factory\LoggerBuilderInterface;

/**
 * Builder to implement Logger with Null object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class NullLoggerBuilder implements LoggerBuilderInterface
{

    /**
     * This method MUST return a valid PSR3 logger
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() : \Psr\Log\LoggerInterface
    {
        return new \Psr\Log\NullLogger;
    }

    /**
     * This method MUST return the name of the main class
     * @return string
     */
    public function getMainCLassName() : string
    {
        return '\Psr\Log\NullLogger';
    }

    /**
     * This method MUST return the name of the package name
     * @return string
     */
    public function getPackageName() : string
    {
        return 'psr/log';
    }
}
