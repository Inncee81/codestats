<?php

namespace CodeStats\Types;
/**
 * Class XP
 * @see https://github.com/Nicd/code-stats/blob/master/lib/code_stats/xp_calculator.ex
 * @package CodeStats\Types
 */
class XP
{

    /**
     * Level factor which is used to calculate the level
     */
    const LEVEL_FACTOR = 0.025;

    /**
     * The name for which the XP belongs to
     * @var string
     */
    public $name = "";
    /**
     * An uniform key
     * @var string
     */
    public $key = "";
    /**
     * XP
     * @var int
     */
    public $xp = 0;
    /**
     * New XP received
     * @var int
     */
    public $new_xp = 0;

    /**
     * XP constructor.
     * @param $name
     * @param $xp
     * @param int $new_xp
     */
    public function __construct($name, $xp, $new_xp = 0)
    {
        $this->key = $this->generateKey($name);
        $this->name = $name;
        $this->xp = $xp;
        $this->new_xp = $new_xp;
    }

    /**
     * Make the name uniform
     * @param $name
     * @return string
     */
    protected function generateKey($name)
    {
        return strtoupper(str_replace(" ", "_", $name));
    }

    /**
     * Get the progress to the next level in percent
     * @return float|int
     */
    public function getLevelProgress()
    {
        $level = $this->getLevel();
        $currentLevelXP = $this->getNextLevel(($level - 1));
        $nextLevelXP = $this->getNextLevel($level);

        $haveXP = $this->xp - $currentLevelXP;

        $neededXP = $nextLevelXP - $currentLevelXP;

        if ($neededXP == 0) {
            return 0;
        }
        return round(($haveXP / $neededXP) * 100);
    }

    /**
     * Get the current level based on XP
     * @return float|int
     */
    public function getLevel()
    {
        if (($xp = $this->xp + $this->new_xp) == 0) {
            return 0;
        }
        return floor(self::LEVEL_FACTOR * sqrt($xp));
    }

    /**
     * Get the amount of XP required to reach the next level from the given level.
     * @param $level
     * @return number
     */
    public function getNextLevel($level)
    {
        return pow(ceil(($level + 1) / self::LEVEL_FACTOR), 2);
    }

    /**
     * @return int
     */
    public function getXP()
    {
        return ($this->xp + $this->new_xp);
    }
}