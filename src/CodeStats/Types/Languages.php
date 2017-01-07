<?php

namespace CodeStats\Types;

/**
 * Class Languages
 * @package CodeStats\Types
 */
class Languages implements \IteratorAggregate
{

    /**
     * Array containing all the languages
     * @var array
     */
    protected $language = [];

    /**
     * Used for flyweight pattern when sorting languages
     * @var bool
     */
    private $languageSorted = false;

    /**
     * Languages constructor.
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
        return new \ArrayIterator($this->language);
    }

    /**
     * Sort the language array from hight to low
     * @return array
     */
    public function sort()
    {
        //Flyweight because sorting can be heavy
        if ($this->languageSorted) {
            return $this->language;
        }

        //Because uasort is sorting the array by reference, we can do this
        uasort($this->language, function (XP $a, XP $b) {
            //Sorting by biggest XP on top, high to low
            return ($a->getXP() < $b->getXP());
        });

        return $this->language;
    }

    /**
     * @param $key
     *
     * @return \CodeStats\Types\XP
     */
    public function get($key)
    {
        $key = strtoupper($key);
        if (!isset($this->language[$key])) {
            return "";
        }

        return $this->language[$key];
    }

    /**
     * Parse an array / stdClass too internal array containing all the languages
     * @param $languages
     */
    public function parse($languages)
    {
        foreach ((array)$languages as $name => $object) {
            $xp = new XP($name, $object->xps, $object->new_xps);
            $this->add($xp);
        }
    }

    /**
     * Adds Language to the array
     * @param XP $language
     */
    public function add(XP $language)
    {
        $this->language[$language->key] = $language;
        //Invalidate cache
        $this->languageSorted = false;
    }
}