<?php

namespace DS3\Framework\HTTP;

/**
 * Parameter Bag, contains values and related keys.
 */
class ParameterBag
{
    /* --- ATTRIBUTES --- */

    private $parameters = array();

    /* --- CONSTRUCTORS --- *
    /**
     * Default constructor
     */
    public function __construct($parameters = array())
    {
        $this->parameters = $parameters;
    }

    /* --- METHODS --- */

    /**
     * Returns all parameters
     * @return mixed[] Parameters
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * Returns all keys
     * @return string[] Keys
     */
    public function keys()
    {
        return array_keys($this->parameters);
    }

    /**
     * Replace parameters
     * @param  mixed[] $parameters Parameter to replace
     * @return void
     */
    public function replace(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Add parameters
     * @param mixed[] $parameters Parameters to add
     * @param boolean $erase If true, duplicate keys will be overwritten
     * @return boolean true if parameter has been added, false otherwise
     */
    public function add($parameters, $erase = false)
    {
        foreach ($parameters as $key => $value) {
            if ($this->has($key) && !$erase)
                return false;
            $this->set($key, $value);
        }
        return true;
    }

    /**
     * Returns parameter's value
     * @param  string $key     Key
     * @param  mixed $default Default value to return if parameter doesn't exist
     * @return mixed          Parameter's value
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->parameters[$key];
        }

        return $default;
    }

    /**
     * Change parameter's value, create if doesn't exist
     * @param string $key   Parameter's key
     * @param mixed $value Parameter's value
     * @return ParameterBag updated ParameterBag
     */
    public function set($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Check if a parameter exists
     * @param  string  $key Cle
     * @return boolean      True if parameter exists
     */
    public function has($key)
    {
        return array_key_exists($key, $this->parameters);

    }

    /**
     * Remove a parameter
     * @param  string $key Parameter's key
     * @return void
     */
    public function remove($key)
    {
        unset($this->parameters[$key]);
    }

    /**
     * Count number of parameters
     * @return int Number of Parameters
     */
    public function count()
    {
        return count($this->parameters);
    }
}
