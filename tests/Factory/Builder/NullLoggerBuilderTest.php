<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover NullLoggerBuilder
 */
class NullLoggerBuilderTest extends TestCase
{

    /**
     * @test
     */
    public function testGetMainClasseName()
    {
        $nullLoggerBuilder = new \vfalies\tmdb\Factory\Builder\NullLoggerBuilder();

        $this->assertEquals('\Psr\Log\NullLogger', $nullLoggerBuilder->getMainCLassName());
    }

    /**
     * @test
     */
    public function testGetLogger()
    {
        $nullLoggerBuilder = new \vfalies\tmdb\Factory\Builder\NullLoggerBuilder();

        $this->assertInstanceOf(\Psr\Log\NullLogger::class, $nullLoggerBuilder->getLogger());
    }

   /**
     * @test
     */
    public function testGetPackageName()
    {
        $nullLoggerBuilder = new \vfalies\tmdb\Factory\Builder\NullLoggerBuilder();

        $this->assertEquals('psr/log', $nullLoggerBuilder->getPackageName());
    }
}
