<?php

namespace DS3\Application\Query;

/**
 * Serie
 */
class Serie
{
    /* --- ATTRIBUTES --- */

    /**
     * @var mixed
     */
    private $id;

    /**
     * @var Measurment[]
     */
    private $measurments;

    /**
     * Serie constructor.
     * @param mixed $id
     * @param Measurment[] $measurments
     */
    public function __construct($id, array $measurments)
    {
        $this->id = $id;
        $this->measurments = $measurments;
    }

    public static function fromArray(array $input)
    {

    }

    /* --- GETTERS --- */

    /**
     * Returns serie's id
     * @return mixed
     */
    public function getId () 
    {
    	return $this->id;
    }

    /**
     * Return serie's measurments
     * @return Measurment[]
     */
    public function getMeasurments()
    {
        return $this->measurments;
    }


}
