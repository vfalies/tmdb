<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover MonologBuilder
 */
class MonologBuilderTest extends TestCase
{
    protected $monologBuilder = null;


    public function setUp()
    {
        parent::setUp();

        $this->monologBuilder = new \vfalies\tmdb\Factory\Builder\MonologBuilder();
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
        $this->monologBuilder->newHandler(\vfalies\tmdb\Media::class);
    }
}
