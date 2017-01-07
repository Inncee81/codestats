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
    /**
     * Used for storing sorted dates
     * @var array
     */
    public $datesSorted = [];

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
        //Invalidate cache
        $this->datesSorted = [];
    }

    /**
     * Parses an array too the internal array, actually useless function
     * but too be consistently with the rest of the code it is here.
     * @param $dates
     */
    public function parse($dates)
    {
        $this->dates = array_merge((array)$this->dates, (array)$dates);
        //Invalidate cache
        $this->datesSorted = [];
    }

    /**
     * Gets average XP gained in time
     * @return float
     */
    public function getAverage()
    {
        return round(array_sum($this->dates) / count($this->dates));
    }

    /**
     * Gets the first date starts programming
     * @return \dateTime
     */
    public function getFirstDate()
    {
        $dates = $this->sort();
        reset($dates);


        $date = new \dateTime(key($dates));

        //Codestats.net has programing since, so minus 1 day.
        $date->sub(new \DateInterval('P1D'));
        return $date;
    }

    /**
     * Sort date array
     * @return array
     */
    public function sort()
    {
        //Flyweight because sorting can be heavy
        if (!empty($this->datesSorted)) {
            return $this->datesSorted;
        }

        //Because uksort is sorting the array by reference
        $this->datesSorted = $this->dates;
        uksort($this->datesSorted, function ($a, $b) {
            return (strtotime($a) > strtotime($b));
        });

        return $this->datesSorted;
    }

    /**
     * Gets the last date Codestats.net is updated
     * @return \dateTime
     */
    public function getLastDate()
    {
        $dates = $this->sort();
        end($dates);
        $date = new \dateTime(key($dates));
        return $date;
    }
}