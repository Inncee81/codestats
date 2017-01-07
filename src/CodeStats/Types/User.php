<?php

namespace CodeStats\Types;
/**
 * Class User
 * @package CodeStats\Types
 */
class User
{
    /**
     * @var string
     */
    public $user = "";

    /**
     * @var int
     */
    public $xp = 0;

    /**
     * @var int
     */
    public $totalXP = 0;

    /**
     * @var int
     */
    public $newXP = 0;

    /**
     * @var \CodeStats\Types\Languages
     */
    public $languages = null;

    /**
     * @var \CodeStats\Types\Machines
     */
    public $machines = null;

    /**
     * @var \CodeStats\Types\History
     */
    public $history = null;

    /**
     * User constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->parse($user);
    }

    /**
     * Parses the info of the user
     * @param $user
     */
    public function parse($user)
    {

        if (!($user instanceof \stdClass)) {
            throw new \InvalidArgumentException("Argument is not an object");
        }

        $this->user = $user->user;
        $this->xp = $user->total_xp;
        $this->totalXP = $user->total_xp + $user->new_xp;
        $this->newXP = $user->new_xp;

        if (isset($user->languages)) {
            $this->languages = new Languages();
            $this->languages->parse($user->languages);
        }

        if (isset($user->machines)) {
            $this->machines = new Machines();
            $this->machines->parse($user->machines);
        }

        if (isset($user->dates)) {
            $this->history = new History();
            $this->history->parse($user->dates);
        }
    }

    /**
     * @return XP
     */
    public function getXP()
    {
        return new XP($this->user, $this->xp, $this->newXP);
    }
}