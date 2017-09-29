<?php

namespace vfalies\tmdb;

use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /**
     * [protected description]
     * @var [type]
     */
    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
                ->setMethods(['sendRequest'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testConnect()
    {
        $get = new Account($this->tmdb);
    }
}
