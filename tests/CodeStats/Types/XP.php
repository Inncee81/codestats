<?php

namespace CodeStats\Types;

/**
 * Class XPTest
 * @package CodeStats\Types
 */
class XPTest extends \TestCase
{

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test the constructor of the class.
     */
    public function testClass()
    {
        $xp = new \CodeStats\Types\XP("test", 100, 0);
        $this->assertEquals("TEST", $xp->key);

        $xp = new \CodeStats\Types\XP("two words", 100, 0);
        $this->assertEquals("TWO_WORDS", $xp->key);

        $xp = new \CodeStats\Types\XP("two Capital", 100, 0);
        $this->assertEquals("TWO_CAPITAL", $xp->key);
    }

    /**
     * Tests XP::GetLevel
     */
    public function testGetLevel()
    {
        $xp = new \CodeStats\Types\XP("PHP", 97237, 259);
        $this->assertEquals(7, $xp->getLevel());

        $xp = new \CodeStats\Types\XP("Plain text", 8337, 0);
        $this->assertEquals(2, $xp->getLevel());

        $xp = new \CodeStats\Types\XP("XML", 879, 0);
        $this->assertEquals(0, $xp->getLevel());
    }

    /**
     * Tests XP::getNextLevel
     *
     */
    public function testGetNextLevel()
    {
        $xp = new \CodeStats\Types\XP("test", 0, 0);

        $this->assertEquals(14400, $xp->getNextLevel(2));
        $this->assertEquals(25600, $xp->getNextLevel(3));
        $this->assertEquals(40000, $xp->getNextLevel(4));
    }

    /**
     * Tests XP::getLevelProgress
     * Is the progress calculated correctly
     */
    public function testGetLevelProgress()
    {

        $xp = new \CodeStats\Types\XP("PHP", 97333, 355);
        $this->assertEquals(79, $xp->getLevelProgress());

        $xp = new \CodeStats\Types\XP("Plain text", 8337, 0);
        $this->assertEquals(24, $xp->getLevelProgress());

        $xp = new \CodeStats\Types\XP("XML", 879, 0);
        $this->assertEquals(55, $xp->getLevelProgress());
    }

    /**
     * Test XP::getXP
     * are the XP and the new XP summed up ?
     */
    public function testGetXP()
    {
        $xp = new \CodeStats\Types\XP("PHP", 97333, 355);
        $this->assertEquals(97688, $xp->getXP());

        $xp = new \CodeStats\Types\XP("Plain text", 8337, 0);
        $this->assertEquals(8337, $xp->getXP());
    }
}
