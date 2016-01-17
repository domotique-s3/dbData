<?php

namespace DS3\Application\Query;

/**
 * Represente a measure.
 */
class Measurment
{
    /* --- ATTRIBUTES --- */

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var number
     */
    private $moment;

    /**
     * Measurment constructor.
     *
     * @param mixed  $value
     * @param number $moment
     */
    public function __construct($value, $moment)
    {
        $this->value = $value;
        $this->moment = $moment;
    }

    /* --- GETTERS --- */

    /*!
     * Returns measurment's value
     */
    public function getValue()
    {
        return $this->value;
    }

    /*!
     * Returns measurment's moment (horodatage)
     */
    public function getMoment()
    {
        return $this->moment;
    }
}
