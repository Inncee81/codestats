<?php

namespace CodeStats;

/**
 * Provides a method to get the output of an URL
 * Class Provider
 * @package CodeStats
 */
class Provider
{
    /**
     * Timout in miliseconds
     * @var int
     */
    public $connectTimeout = 1000;
    /**
     * Timout in miliseconds
     * @var int
     */
    public $timeout = 1000;


    /**
     * Provider constructor.
     */
    public function __construct()
    {

    }

    /**
     * Do the call too the provided url and return the output
     * @param $url
     * @return mixed
     * @throws \Exception
     */
    public function call($url)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException("Url is empty");
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $this->timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, "Curl");

        // $output contains the output string
        $output = curl_exec($ch);

        if ($output === false) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $output;
    }

}