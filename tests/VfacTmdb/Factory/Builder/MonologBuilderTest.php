<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover MonologBuilder
 */
class MonologBuilderTest extends TestCase
{
    protected $monologBuilder = null;


    public function setUp() : void
    {
        parent::setUp();

        $this->monologBuilder = new \VfacTmdb\Factory\Builder\MonologBuilder();
    }

    /**
     * @test
     */
    public function testGetMainClasseName()
    {
        $this->assertEquals('Monolog\Logger', $this->monologBuilder->getMainCLassName());
    }

    /**
     * @test
     */
    public function testGetLogger()
    {
        $this->assertInstanceOf(\Monolog\Logger::class, $this->monologBuilder->getLogger());
    }

    /**
      * @test
      */
    public function testGetPackageName()
    {
        $this->assertEquals('monolog/monolog', $this->monologBuilder->getPackageName());
    }

    /**
     *  @test
     *  @expectedException InvalidArgumentException
     */
    public function testNewHandler()
    {
        $this->monologBuilder->newHandler(\VfacTmdb\Media::class);
    }
}
