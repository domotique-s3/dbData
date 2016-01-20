<?php

namespace DS3\Application\Query;

use DS3\Framework\HTTP\Request;

class URLQuery extends Query
{
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
            if ($optional) {
                return null;
            }
            throw new \InvalidArgumentException("$param is missing");
        }
        if (($value = trim($value)) == '') {
            if ($optional) {
                return null;
            }
            throw new \InvalidArgumentException("$param is empty");
        }

        return $value;
    }
}
