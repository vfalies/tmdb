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


namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\Factory\LoggerBuilderInterface;
use vfalies\tmdb\Interfaces\Factory\BuilderInterface;
use vfalies\tmdb\Exceptions\MissingDependencyException;

/**
 * Factory class
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Factory
{
    /**
     * Logger builder
     * @var \vfalies\tmdb\Interfaces\Factory\loggerBuilderInterface
     */
    protected $loggerBuilder;

    /**
     * Create
     * @param array $loggerConf
     * @return \static
     */
    public static function create($loggerConf = ['builder' => 'NullLogger', 'config' => []])
    {
        $factory = new static();
        $factory->setLoggerBuilder($factory->getBuilder($loggerConf['builder']));

        return $factory;
    }

    /**
     * Get Tmdb object
     * @param string $api_key API Key
     * @param int $version API Version (not yet used)
     * @return TmdbInterface
     */
    public function getTmdb($api_key, $version = 3)
    {
        return new Tmdb($api_key, $version, $this->loggerBuilder->getLogger());
    }

    /**
     * Get Builder
     * @param string $builder
     * @param array $args
     * @return type
     */
    public function getBuilder($builder, array $args = [])
    {
        $class = "\\vfalies\\tmdb\\Factory\\Builder\\{$builder}Builder";

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
     * @param $builderConfig
     * @return array
     */
    public function extractConfig(array $builderConfig)
    {
        return isset($builderConfig['config']) ? $builderConfig['config']:[];
    }

    /**
     * Check dependency
     * @param BuilderInterface $builder
     * @return boolean
     * @throws MissingDependencyException
     */
    public function checkDependency(BuilderInterface $builder)
    {
        if (! class_exists($builder->getMainClassName())) {
            $message = "missing {$builder->getPackageName()}, please install it using composer : composer require {$builder->getPackageName()}";
            throw new MissingDependencyException($message);
        }

        return true;
    }
}
