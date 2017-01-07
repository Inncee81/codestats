<?php

namespace CodeStats\Types;
/**
 * Class User
 * @package CodeStats\Types
 */
class User
{

    public $user = "";
    public $xp = 0;
    public $totalXP = 0;
    public $newXP = 0;

    public $languages = null;
    public $machines = null;
    public $history = null;

    /**
     * User constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->parse($user);
    }

    public function getXP() {

        return new XP($this->user, $this->xp, $this->newXP);
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
}