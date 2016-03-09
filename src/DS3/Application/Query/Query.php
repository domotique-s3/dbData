<?php

namespace DS3\Application\Query;

/**
 * Holds a query.
 *
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class Query
{
    /**
     * @var string
     */
    protected $sensorIdColumn;

    /**
     * @var string
     */
    protected $valuesColumn;

    /**
     * @var string
     */
    protected $timestampColumn;

    /**
     * @var float|null
     */
    protected $start;

    /**
     * @var float|null
     */
    protected $end;

    /**
     * @var string[]
     */
    protected $sensors;

    /**
     * @return string
     */
    public function getSensorIdColumn()
    {
        return $this->sensorIdColumn;
    }

    /**
     * @param string $sensorIdColumn
     */
    public function setSensorIdColumn($sensorIdColumn)
    {
        $this->sensorIdColumn = $sensorIdColumn;
    }

    /**
     * @return string
     */
    public function getValuesColumn()
    {
        return $this->valuesColumn;
    }

    /**
     * @param string $valuesColumn
     */
    public function setValuesColumn($valuesColumn)
    {
        $this->valuesColumn = $valuesColumn;
    }

    /**
     * @return string
     */
    public function getTimestampColumn()
    {
        return $this->timestampColumn;
    }

    /**
     * @param string $timestampColumn
     */
    public function setTimestampColumn($timestampColumn)
    {
        $this->timestampColumn = $timestampColumn;
    }

    /**
     * @return float|null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param float|null $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return float|null
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param float|null $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return \string[]
     */
    public function getSensors()
    {
        return $this->sensors;
    }

    /**
     * @param \string[] $sensors
     */
    public function setSensors($sensors)
    {
        $this->sensors = $sensors;
    }

    /**
     * @return string[]
     */
    public function getTables()
    {
        return array_keys($this->sensors);
    }

    /**
     * @çeturn string[]|null
     */
    public function getSensorsByTable($table)
    {
        return (isset($this->sensors[$table])) ? $this->sensors[$table] : null;
    }
}
