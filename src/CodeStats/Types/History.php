<?php

namespace CodeStats\Types;

/**
 * Class History
 * @package CodeStats\Types
 */
class History implements \IteratorAggregate
{

    /**
     * Array containing all the dates.
     * @var array
     */
    public $dates = [];

    public function __construct()
    {
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->dates);
    }

    /**
     * Add a date too the internal array.
     * @param $date
     * @param $xp
     */
    public function add($date, $xp)
    {
        $this->dates[$date] = $xp;
    }

    /**
     * Parses an array too the internal array, actually useless function
     * but too be consistently with the rest of the code it is here.
     * @param $dates
     */
    public function parse($dates)
    {
        $this->dates = array_merge((array)$this->dates, (array)$dates);
    }
}