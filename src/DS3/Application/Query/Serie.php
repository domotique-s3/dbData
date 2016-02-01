<?php

namespace DS3\Application\Query;

/**
 * Serie.
 */
class Serie
{
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
     *
     * @param mixed        $id
     * @param Measurment[] $measurments
     */
    public function __construct($id, array $measurments)
    {
        $this->id = $id;
        $this->measurments = $measurments;
    }

    /**
     * Returns the id of the serie's sensor
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the measurments of the serie
     *
     * @return Measurment[]
     */
    public function getMeasurments()
    {
        return $this->measurments;
    }
}
