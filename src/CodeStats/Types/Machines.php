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
    protected $machines = [];

    /**
     * Used for flyweight pattern when sorting machines
     * @var bool
     */
    private $machinesSorted = false;

    /**
     * Machines constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        $this->sort();
        return new \ArrayIterator($this->machines);
    }

    /**
     * Sort machine array from hight to low
     * @return array
     */
    public function sort()
    {
        //Flyweight because sorting can be heavy
        if ($this->machinesSorted) {
            return $this->machines;
        }

        //Because uasort is sorting the array by reference, we can do this
        uasort($this->machines, function (XP $a, XP $b) {
            //Sorting by biggest XP on top, high to low
            return ($a->getXP() < $b->getXP());
        });

        return $this->machines;
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
        //Invalidate cache
        $this->machinesSorted = false;
    }

}