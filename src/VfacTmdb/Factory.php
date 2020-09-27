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


namespace VfacTmdb;

use VfacTmdb\Interfaces\Factory\LoggerBuilderInterface;
use VfacTmdb\Interfaces\Factory\BuilderInterface;
use VfacTmdb\Exceptions\MissingDependencyException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

/**
 * Factory class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Factory
{
    /**
     * Logger builder
     * @var LoggerBuilderInterface
     */
    protected $loggerBuilder;

    /**
     * Create
     * @param array $loggerConf
     * @return Factory
     */
    public static function create(array $loggerConf = ['builder' => 'NullLogger', 'config' => []]) : Factory
    {
        $factory = new static();
        $factory->setLoggerBuilder($factory->getBuilder($loggerConf['builder']));

        return $factory;
    }

    /**
     * Get Tmdb object
     * @param string $apiKey API Key
     * @param int $version API Version (not yet used)
     * @return Tmdb
     */
    public function getTmdb(string $apiKey, int $version = 3) : Tmdb
    {
        return new Tmdb($apiKey, $version, $this->loggerBuilder->getLogger(), new HttpClient(new \GuzzleHttp\Client()));
    }

    /**
     * Get Builder
     * @param string $builder
     * @param array $args
     * @return LoggerBuilderInterface
     */
    public function getBuilder(string $builder, array $args = []) : LoggerBuilderInterface
    {
        $class = "\\VfacTmdb\\Factory\\Builder\\{$builder}Builder";

        $reflection = new \ReflectionClass($class);

        return $reflection->newInstanceArgs($args);
    }

    /**
     * Set logger builder
     * @param LoggerBuilderInterface $loggerBuilder
     * @return Factory
     */
    public function setLoggerBuilder(LoggerBuilderInterface $loggerBuilder) : Factory
    {
        $this->loggerBuilder = $loggerBuilder;

        return $this;
    }

    /**
     * Check dependency
     * @param BuilderInterface $builder
     * @return bool
     * @throws MissingDependencyException
     */
    public function checkDependency(BuilderInterface $builder) : bool
    {
        if (!class_exists($builder->getMainClassName())) {
            $message = "missing {$builder->getPackageName()}, please install it using composer : composer require {$builder->getPackageName()}";
            throw new MissingDependencyException($message);
        }

        return true;
    }
}
