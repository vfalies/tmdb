<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\Factory\LoggerBuilderInterface;
use vfalies\tmdb\Interfaces\Factory\BuilderInterface;
use vfalies\tmdb\Exceptions\MissingDependencyException;

class Factory
{
    protected $loggerBuilder;

    public static function create($loggerConf = ['builder' => 'NullLogger', 'config' => []])
    {
        $factory = new static();
        $factory->setLoggerBuilder($factory->getBuilder($loggerConf['builder']), $factory->extractConfig($loggerConf));

        return $factory;
    }

    /**
     *
     * @param string $api_key
     * @return \vfalies\tmdb\Tmdb
     */
    public function getTmdb(string $api_key)
    {
        return new Tmdb($api_key, $this->loggerBuilder->getLogger());
    }

    public function getBuilder($builder, array $args = [])
    {
        $class = "\\vfalies\\tmdb\\Factory\\Builder\\{$builder}Builder";

        $reflection = new \ReflectionClass($class);

        return $reflection->newInstanceArgs($args);
    }

    public function setLoggerBuilder(LoggerBuilderInterface $loggerBuilder)
    {
        $this->loggerBuilder = $loggerBuilder;

        return $this;
    }

    /**
     * @param $builderConfig
     * @return array
     */
    public function extractConfig(array $builderConfig)
    {
        return isset($builderConfig['config']) ? $builderConfig['config']:[];
    }

    public function checkDependency(BuilderInterface $builder)
    {
        if ( ! class_exists($builder->getMainCLassName()))
        {
            $message = "missing {$builder->getPackageName()}, please install it using composer : composer require {$builder->getPackageName()}";
            throw new MissingDependencyException($message);
        }

        return true;
    }
}