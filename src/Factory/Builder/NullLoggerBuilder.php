<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
* @package Tmdb 
* @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Factory\Builder;

use vfalies\tmdb\Interfaces\Factory\LoggerBuilderInterface;

class NullLoggerBuilder implements LoggerBuilderInterface
{

    /**
     * This method MUST return a valid PSR3 logger
     * @return \Psr\Log\NullLogger
     */
    public function getLogger()
    {
        return new \Psr\Log\NullLogger;
    }

    /**
     * This method MUST return the name of the main class
     * @return string
     */
    public function getMainCLassName()
    {
        return '\Psr\Log\NullLogger';
    }

    /**
     * This method MUST return the name of the package name
     * @return string
     */
    public function getPackageName()
    {
        return 'psr/log';
    }
}
