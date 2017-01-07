<?php

namespace CodeStats;

/**
 * Class ProviderTest
 * @package CodeStats
 */
class ProviderTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test the Provider::call
     */
    public function testCall()
    {

        $provided = new \CodeStats\Provider();
        $this->expectException(\InvalidArgumentException::class);
        $provided->call("");
    }
}