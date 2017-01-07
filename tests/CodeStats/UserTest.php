<?php

namespace CodeStats;

/**
 * Class UserTest
 * @package CodeStats
 */
class UserTest extends \TestCase
{

    private $stub = null;

    public function setUp()
    {
        parent::setUp();

        $home = new \stdClass();
        $home->xps = 53335;
        $home->new_xps = 3604;

        $machines = new \stdClass();
        $machines->Home = $home;

        $php = new \stdClass();
        $php->xps = 100570;
        $php->new_xps = 3592;

        $languages = new \stdClass();
        $languages->PHP = $php;

        $dates = [
            "2016-12-01" => 296,
            "2016-08-31" => 1326
        ];

        $this->stub = $this->createMock(Provider::class);

        $user = new \stdClass();
        $user->user = "Thijs Bekke";
        $user->total_xp = 816;
        $user->new_xp = 521;
        $user->languages = $languages;
        $user->machines = $machines;
        $user->dates = $dates;

        $this->stub->method('call')
            ->willReturn(json_encode($user));

    }

    /**
     * Test the Provider::call
     */
    public function testClass()
    {

        $usr = new \CodeStats\User();
        $usr->setProvider($this->stub);

        $object = $usr->get("thijsbekke");

        $this->assertTrue(($object instanceof \CodeStats\Types\User));
        $this->assertEquals($object->user, "Thijs Bekke");
        $this->assertEquals($object->totalXP, 1337);
        $this->assertEquals($object->newXP, 521);

        $this->assertTrue(($object->languages instanceof \CodeStats\Types\Languages));
        $this->assertTrue(($object->machines instanceof \CodeStats\Types\Machines));
        $this->assertTrue(($object->history instanceof \CodeStats\Types\History));
    }
}