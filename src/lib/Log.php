<?php

namespace vfalies\tmdb\lib;

use Psr\Log\LoggerInterface;

class Log
{
    private $logger = null;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param string $name
     * @param mixed $arguments
     * @throws \Exception
     */
    public function __call(string $name, $arguments)
    {
        switch ($name)
        {
            case 'info':
            case 'error':
            case 'alert':
            case 'critical':
            case 'debug':
            case 'emergency':
            case 'log':
            case 'warning':
                if ($this->logger)
                {
                    $message = $arguments[0];
                    $context = (isset($arguments[1])) ? $arguments[1] : [];
                    $this->logger->$name($message, $context);
                }
                break;
            default:
                throw new \Exception('Logging  failed with level '.$name);
        }
    }

}