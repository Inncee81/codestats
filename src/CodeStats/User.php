<?php


namespace CodeStats;

/**
 * Get information about a user
 * Class User
 * @package CodeStats
 */
class User
{
    /**
     * @var null
     */
    private $provider = null;

    /**
     * User constructor.
     */
    public function __construct()
    {

    }

    /**
     * Get an object with info of the provided user.
     * @param $username
     * @return bool|Types\User
     */
    public function get($username)
    {

        if (empty($username)) {
            throw new \InvalidArgumentException("No username was specified");
        }

        //Call can only be a string with the result or an exception
        $result = $this->getProvider()->call($this->url($username));

        $object = json_decode($result);

        if (is_null($object) || $object === false) {
            throw new \Exception("Invalid data returned from server");
        }

        return new Types\User($object);
    }

    /**
     * @return Provider
     */
    public function getProvider()
    {
        if (is_null($this->provider)) {
            $this->provider = new Provider();
        }
        return $this->provider;
    }

    /**
     * Some dependency injection too be able to unittest this class
     * @param $provider
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Create an url to codestats.net
     * @param $username
     * @return string
     */
    protected function url($username)
    {
        return sprintf("https://codestats.net/api/users/%s", urlencode($username));
    }

}