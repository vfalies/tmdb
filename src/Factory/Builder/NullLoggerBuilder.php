<?php

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
