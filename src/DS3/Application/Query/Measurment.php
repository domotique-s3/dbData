<?php

namespace DS3\Application\Query;

/**
 * Represents a measurment, ie. a row in the table.
 */
class Measurment
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var float
     */
    private $timestamp;

    /**
     * Measurment constructor.
     *
     * @param mixed $value
     * @param float $timestamp
     */
    public function __construct($value, $timestamp)
    {
        $this->value = $value;
        $this->timestamp = $timestamp;
    }

    /**
     * Returns the measurment value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the measurment timestamp, ie. the moment when the value was added.
     *
     * @return float
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
