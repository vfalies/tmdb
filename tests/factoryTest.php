<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Factory
 */
class FactoryTest extends TestCase
{

    /**
     *  @test
     */
    public function testCreate()
    {
        $factory = Factory::create();

        $this->assertInstanceOf(Factory::class, $factory);
    }

    /**
     * @test
     */
    public function testGetTmdb()
    {
        $tmdb = Factory::create()->getTmdb('fake_api_key');

        $this->assertInstanceOf(Tmdb::class, $tmdb);
    }

    /**
     * @test
     */
    public function testCheckDependency()
    {
        $factory = new Factory();
        $this->assertTrue($factory->checkDependency(
            $this->getBuilder('stdClass', 'php/php')
        ));
    }
    /**
     * @expectedException vfalies\tmdb\Exceptions\MissingDependencyException
     */
    public function testCheckMissingDependency()
    {
        $factory = new Factory();
        $factory->checkDependency(
            $this->getBuilder('IDontExist', 'php/php')
        );
    }

    protected function getBuilder($className, $package)
    {
        $builder = $this->getMockForAbstractClass('\vfalies\tmdb\Interfaces\Factory\BuilderInterface');
        $builder->expects($this->any())->method('getMainClassName')->will($this->returnValue($className));

        $builder->expects($this->any())->method('getPackageName')->will($this->returnValue($package));

        return $builder;
    }

    public function testExtractConfig()
    {
        $builderConfig = [];

        $factory = new Factory();
        $extract = $factory->extractConfig($builderConfig);

        $this->assertEmpty($extract);

        $builderConfig['config'] = 'testconfig';
        $extract = $factory->extractConfig($builderConfig);

        $this->assertEquals('testconfig', $extract);
    }
}
