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
    public $language = [];

    public function __construct()
    {
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->language);
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
    }
}