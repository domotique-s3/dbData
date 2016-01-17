<?php
/**
 * Created by PhpStorm.
 * User: palra
 * Date: 1/4/16
 * Time: 2:46 PM.
 */
namespace DS3\Application\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $table = 'a';
        $sensorColumn = 'b';
        $timestampColumn = 'c';
        $valuesColumn = 'd';
        $sensorIds = array('e', 3);
        $startTime = new \DateTime('now');
        $endTime = new \DateTime('tomorrow');

        $query = new Query($table, $sensorColumn, $timestampColumn, $valuesColumn, $sensorIds, $startTime, $endTime);

        $this->assertEquals($table, $query->getTable());
        $this->assertEquals($sensorColumn, $query->getSensorColumn());
        $this->assertEquals($timestampColumn, $query->getTimestampColumn());
        $this->assertEquals($sensorIds, $query->getSensorIds());
        $this->assertEquals($startTime, $query->getStartTime());
        $this->assertEquals($endTime, $query->getEndTime());
    }

    public function testInvalidDateTime()
    {
        $table = 'a';
        $sensorColumn = 'b';
        $timestampColumn = 'c';
        $valuesColumn = 'd';
        $sensorIds = array('e', 3);
        $startTime = new \DateTime('tomorrow');
        $endTime = new \DateTime('now');

        $this->setExpectedException('InvalidArgumentException');
        new Query($table, $sensorColumn, $timestampColumn, $valuesColumn, $sensorIds, $startTime, $endTime);
    }
}
