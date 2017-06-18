<?php

namespace vfalies\tmdb\Factory\Builder;

use vfalies\tmdb\Factory\LoggerBuilderInterface;
use Psr\Log\NullLogger;

class NullLoggerBuilder implements LoggerBuilderInterface
{

    /**
     * This method MUST return a valid PSR3 logger
     * @return \Psr\Log\NullLogger
     */
    public function getLogger(): \Psr\Log\LoggerInterface
    {
        return new \Psr\Log\NullLogger;
    }

    /**
     * This method MUST return the name of the main class
     * @return string
     */
    public function getMainCLassName(): string
    {
        return '\Psr\Log\NullLogger';
    }

    /**
     * This method MUST return the name of the package name
     * @return string
     */
    public function getPackageName(): string
    {
        return 'psr/log';
    }

}
