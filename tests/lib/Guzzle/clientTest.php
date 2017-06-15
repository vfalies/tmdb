<?php

namespace vfalies\tmdb\lib\Guzzle;

use PHPUnit\Framework\TestCase;
use vfalies\tmdb\Tmdb;

/**
 * @cover Client
 */
class ClientTest extends TestCase
{

    protected $tmdb = null;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    public function testGetResponseOk()
    {
        $this->markTestIncomplete();
    }
}