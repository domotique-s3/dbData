<?php

namespace DS3\Application\Query;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use DS3\Framework\HTTP\Request;

/**
 * Holds a query
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
     * @param string $table
     * @param string $sensorColumn
     * @param string $timestampColumn
     * @param string $valuesColumn
     * @param \string[] $sensorIds
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     */
    public function __construct($table, $sensorColumn, $timestampColumn, $valuesColumn, array $sensorIds, \DateTime $startTime = null, \DateTime $endTime = null)
    {
        $this->table = (string) $table;
        $this->sensorColumn = (string) $sensorColumn;
        $this->timestampColumn = (string) $timestampColumn;
        $this->valuesColumn = (string)$valuesColumn;
        $this->sensorIds = $sensorIds;
        $this->startTime = $startTime;

        if($endTime < $this->startTime)
            throw new \InvalidArgumentException('$endTime is not supposed to be anterior to $startTime');
        $this->endTime = $endTime;
    }

    public static function fromRequest(Request $request)
    {
        $table = self::getParam(self::TABLE_NAME, $request);
        $sensorColumn = self::getParam(self::SENSOR_ID_COLUMN, $request);
        $timestampColumn = self::getParam(self::TIMESTAMP_COLUMN, $request);
        $valuesColumn = self::getParam(self::VALUES_COLUMN, $request);
        $sensorIds = json_decode(self::getParam(self::SENSOR_IDS, $request));
        $startTime = self::getParam(self::START_TIME, $request, true);
        $endTime = self::getParam(self::END_TIME, $request, true);

        return new static($table, $sensorColumn, $timestampColumn, $valuesColumn, $sensorIds, $startTime, $endTime);
    }

    private static function getParam($param, Request $request, $optional = false)
    {
        $value = $request->getQuery()->get($param);

        if ($value == null) {
            if ($optional)
                return null;
            throw new InvalidArgumentException("$param is missing");
        }
        if (($value = trim($value)) == '') {
            if ($optional)
                return null;
            throw new InvalidArgumentException("$param is empty");
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getSensorColumn()
    {
        return $this->sensorColumn;
    }

    /**
     * @return string
     */
    public function getTimestampColumn()
    {
        return $this->timestampColumn;
    }

    /**
     * @return string
     */
    public function getValuesColumn()
    {
        return $this->valuesColumn;
    }

    /**
     * @return \string[]
     */
    public function getSensorIds()
    {
        return $this->sensorIds;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}