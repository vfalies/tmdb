<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;

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

    public function testCheckMissingDependency()
    {
        $this->expectException(\VfacTmdb\Exceptions\MissingDependencyException::class);

        $factory = new Factory();
        $factory->checkDependency(
            $this->getBuilder('IDontExist', 'php/php')
        );
    }

    /**
     * Get Builder
     * @param  string $className
     * @param  string $package
     */
    protected function getBuilder($className, $package)
    {
        $builder = $this->getMockForAbstractClass('\VfacTmdb\Interfaces\Factory\BuilderInterface');
        $builder->expects($this->any())->method('getMainClassName')->will($this->returnValue($className));

        $builder->expects($this->any())->method('getPackageName')->will($this->returnValue($package));

        return $builder;
    }
}
