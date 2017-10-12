<?php

namespace VfacTmdb;

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
        $nullLoggerBuilder = new \VfacTmdb\Factory\Builder\NullLoggerBuilder();

        $this->assertEquals('\Psr\Log\NullLogger', $nullLoggerBuilder->getMainCLassName());
    }

    /**
     * @test
     */
    public function testGetLogger()
    {
        $nullLoggerBuilder = new \VfacTmdb\Factory\Builder\NullLoggerBuilder();

        $this->assertInstanceOf(\Psr\Log\NullLogger::class, $nullLoggerBuilder->getLogger());
    }

    /**
      * @test
      */
    public function testGetPackageName()
    {
        $nullLoggerBuilder = new \VfacTmdb\Factory\Builder\NullLoggerBuilder();

        $this->assertEquals('psr/log', $nullLoggerBuilder->getPackageName());
    }
}
