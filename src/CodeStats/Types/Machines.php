<?php

namespace CodeStats\Types;

/**
 * Class Machines
 * @package CodeStats\Types
 */
class Machines implements \IteratorAggregate
{

    /**
     * Internal array containing all the machines
     * @var array
     */
    public $machines = [];

    public function __construct()
    {
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->machines);
    }

    /**
     * Parses an array/stdClass too the internal array.
     * @param $machines
     */
    public function parse($machines)
    {
        foreach ((array)$machines as $name => $object) {
            $xp = new XP($name, $object->xps, $object->new_xps);
            $this->add($xp);
        }
    }

    /**
     * A machine is actually an XP, it has a name and levels,
     * This method will add it too the internal array
     * @param XP $machine
     */
    public function add(XP $machine)
    {
        $this->machines[$machine->key] = $machine;
    }
}