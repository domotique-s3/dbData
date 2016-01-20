<?php

namespace DS3\Application\Query;

use DS3\Framework\HTTP\Request;

/**
 * Holds a query.
 *
 * @author Loïc Payol <loic.payol@gmail.com>
 */
class Query
{
    const TABLE_NAME = 'tableName';
    const SENSOR_ID_COLUMN = 'sensorIdColumn';
    const TIMESTAMP_COLUMN = 'timestampColumn';
    const VALUES_COLUMN = 'valuesColumn';
    const SENSOR_IDS = 'sensorIds';
    const START_TIME = 'startTime';
    const END_TIME = 'endTime';

    /**
     * @var string The table where to make the query
     */
    private $table;

    /**
     * @var string The column where to fetch the sensor IDs
     */
    private $sensorColumn;

    /**
     * @var string The column where to fetch the timestamps
     */
    private $timestampColumn;

    /**
     * @var string The column where to fetch the values
     */
    private $valuesColumn;

    /**
     * @var string[] An array of sensor IDs
     */
    private $sensorIds = array();

    /**
     * @var \DateTime The starting date of the time interval
     */
    private $startTime;

    /**
     * @var \DateTime The ending date of the time interval
     */
    private $endTime;

    /**
     * Query constructor.
     *
     * @param string    $table
     * @param string    $sensorColumn
     * @param string    $timestampColumn
     * @param string    $valuesColumn
     * @param \string[] $sensorIds
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     */
    public function initialize($table, $sensorColumn, $timestampColumn, $valuesColumn, array $sensorIds, \DateTime $startTime = null, \DateTime $endTime = null)
    {
        $this->table = (string) $table;
        $this->sensorColumn = (string) $sensorColumn;
        $this->timestampColumn = (string) $timestampColumn;
        $this->valuesColumn = (string) $valuesColumn;
        $this->sensorIds = $sensorIds;
        $this->startTime = $startTime;

        if ($endTime < $this->startTime) {
            throw new \InvalidArgumentException('$endTime is not supposed to be anterior to $startTime');
        }
        $this->endTime = $endTime;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getSensorColumn()
    {
        return $this->sensorColumn;
    }

    /**
     * @param string $sensorColumn
     */
    public function setSensorColumn($sensorColumn)
    {
        $this->sensorColumn = $sensorColumn;
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
     * @return string[]
     */
    public function getSensorIds()
    {
        return $this->sensorIds;
    }

    /**
     * @param string[] $sensorIds
     */
    public function setSensorIds($sensorIds)
    {
        $this->sensorIds = $sensorIds;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime = null)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime($endTime = null)
    {
        $this->endTime = $endTime;
    }

}
