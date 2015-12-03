<?php

namespace DS3\Application\Query;

/**
 * Represente a measure
 */
class Measurment
{
    /* --- ATTRIBUTES --- */

    private $value;
    private $moment;

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

    /* --- SETTERS --- */

    /*!
     * Sets measurment's moment
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;
    }

    /*!
     * Sets measurment's value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


}
