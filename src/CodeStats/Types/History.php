<?php

namespace CodeStats\Types;

/**
 * Class History
 * @package CodeStats\Types
 */
class History implements \IteratorAggregate
{

    const DAY = 1;
    const MONTH = 2;

    /**
     * Array containing all the dates.
     * @var array
     */
    protected $dates = [];

    /**
     * Used for flyweight pattern when sorting dates
     * @var bool
     */
    private $datesSorted = false;

    /**
     * History constructor.
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
        return new \ArrayIterator($this->dates);
    }

    /**
     * Sort date array from low to high
     * @return array
     */
    public function sort()
    {
        //Flyweight because sorting can be heavy
        if ($this->datesSorted) {
            return $this->dates;
        }

        //Because uksort is sorting the array by reference, we can do this
        uksort($this->dates, function ($a, $b) {
            //Sorting low to high
            return (strtotime($a) > strtotime($b));
        });

        return $this->dates;
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
        $this->datesSorted = false;
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
        $this->datesSorted = false;
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

    /**
     * Return an ArrayIterator group by Argument
     * @param $group
     * @return \ArrayIterator
     */
    public function getGroupedBy($group)
    {

        $dates = [];

        //Group by every item by their date (month of day of the week)
        foreach ($this->getIterator() as $key => $value) {

            $datetime = new \DateTime($key);


            if (self::MONTH === $group) {
                $group = $datetime->format("n");
            } else {
                $group = $datetime->format("N");
            }

            if (!isset($dates[$group])) {
                $dates[$group] = ["total" => 0, "count" => 0];
            }
            $dates[$group]["total"] = ($dates[$group]["total"] + $value);
            $dates[$group]["count"]++;
        }

        //We have a total and now calculate the average
        foreach ($dates as $group => $array) {
            if (empty($dates[$group]["count"])) {
                continue;
            }

            $dates[$group]["average"] = round(($dates[$group]["total"] / $dates[$group]["count"]));
        }

        ksort($dates);
        return new \ArrayIterator($dates);
    }

}