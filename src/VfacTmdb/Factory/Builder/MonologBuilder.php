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

use Monolog\Logger;
use VfacTmdb\Interfaces\Factory\LoggerBuilderInterface;

/**
 * Builder for Monolog logger
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class MonologBuilder implements LoggerBuilderInterface
{
    /**
     * Logger name string
     * @var string
     */
    protected $loggerName = 'tmdb';

    /**
     * Handler config
     * @var array
     */
    protected $handlersConfig = [
        [
            'class' => 'Monolog\Handler\StreamHandler',
            'params' => ['php://stdout', Logger::DEBUG],
        ],
    ];

    /**
     * Constructor
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->loggerName = isset($config['name']) ? $config['name'] : $this->loggerName;

        $this->handlersConfig = isset($config['handlers']) ? $config['handlers'] : $this->handlersConfig;
    }

    /**
     * Get Logger
     * This method MUST return a valid PSR3 logger
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() : \Psr\Log\LoggerInterface
    {
        $logger = new Logger($this->loggerName);

        foreach ($this->handlersConfig as $config) {
            $handler = $this->newHandler($config['class'], $config['params']);
            $logger->pushHandler($handler);
        }

        return $logger;
    }

    /**
     * Create new handler
     * @param string $class
     * @param array $params
     * @return \Monolog\Handler\HandlerInterface
     */
    public function newHandler(string $class, array $params = []) : \Monolog\Handler\HandlerInterface
    {
        $reflection = new \ReflectionClass($class);

        if (!$reflection->implementsInterface('Monolog\Handler\HandlerInterface')) {
            throw new \InvalidArgumentException();
        }

        return $reflection->newInstanceArgs($params);
    }

    /**
     * Get main class name
     * This method MUST return the name of the main class
     * @return string
     */
    public function getMainClassName() : string
    {
        return 'Monolog\Logger';
    }

    /**
     * Get package name
     * This method MUST return the name of the package name
     * @return string
     */
    public function getPackageName() : string
    {
        return 'monolog/monolog';
    }
}
