<?php
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


namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\Factory\LoggerBuilderInterface;
use vfalies\tmdb\Interfaces\Factory\BuilderInterface;
use vfalies\tmdb\Exceptions\MissingDependencyException;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;

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
    public static function create($loggerConf = ['builder' => 'NullLogger', 'config' => []])
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
    public function getTmdb($apiKey, $version = 3)
    {
        return new Tmdb($apiKey, $version, $this->loggerBuilder->getLogger(), new HttpClient(new \GuzzleHttp\Client()));
    }

    /**
     * Get Builder
     * @param string $builder
     * @param array $args
     * @return LoggerBuilderInterface
     */
    public function getBuilder($builder, array $args = [])
    {
        $class = "\\vfalies\\tmdb\\Factory\\Builder\\{$builder}builder";

        $reflection = new \ReflectionClass($class);

        return $reflection->newInstanceArgs($args);
    }

    /**
     * Set logger builder
     * @param LoggerBuilderInterface $loggerBuilder
     * @return $this
     */
    public function setLoggerBuilder(LoggerBuilderInterface $loggerBuilder)
    {
        $this->loggerBuilder = $loggerBuilder;

        return $this;
    }

    /**
     * Extract config
     * @param array $builderConfig
     * @return array
     */
    public function extractConfig(array $builderConfig)
    {
        return isset($builderConfig['config']) ? $builderConfig['config'] : [];
    }

    /**
     * Check dependency
     * @param BuilderInterface $builder
     * @return bool
     * @throws MissingDependencyException
     */
    public function checkDependency(BuilderInterface $builder)
    {
        if (!class_exists($builder->getMainClassName())) {
            $message = "missing {$builder->getPackageName()}, please install it using composer : composer require {$builder->getPackageName()}";
            throw new MissingDependencyException($message);
        }

        return true;
    }
}
