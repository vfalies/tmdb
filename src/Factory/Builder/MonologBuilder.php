<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Factory\Builder;

use Monolog\Logger;
use vfalies\tmdb\Interfaces\Factory\LoggerBuilderInterface;

/**
 * Builder for Monolog logger

  * @author Vincent Faliès <vincent.falies@gmail.com>
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
        $this->loggerName = isset($config['name']) ? $config['name']:$this->loggerName;

        $this->handlersConfig = isset($config['handlers']) ? $config['handlers']:$this->handlersConfig;
    }

    /**
     * Get Logger
     * This method MUST return a valid PSR3 logger
     * @return \Monolog\Logger
     */
    public function getLogger()
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
     * @return Monolog\Handler\HandlerInterface
     */
    public function newHandler($class, array $params = [])
    {
        $reflection = new \ReflectionClass($class);

        if (! $reflection->implementsInterface('Monolog\Handler\HandlerInterface')) {
            throw new \InvalidArgumentException();
        }

        return $reflection->newInstanceArgs($params);
    }

    /**
     * Get main class name
     * This method MUST return the name of the main class
     * @return string
     */
    public function getMainClassName()
    {
        return 'Monolog\Logger';
    }

    /**
     * Get package name
     * This method MUST return the name of the package name
     * @return string
     */
    public function getPackageName()
    {
        return 'monolog/monolog';
    }
}
