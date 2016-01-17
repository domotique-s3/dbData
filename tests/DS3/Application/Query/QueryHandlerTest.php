<?php
/**
 * Created by PhpStorm.
 * User: palra
 * Date: 1/14/16
 * Time: 6:18 AM.
 */
namespace DS3\Application\Query;

class QueryHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testToSerie_ValidTable()
    {
        $data = array(
            1 => array(
                array(
                    'timestamp' => 10,
                    'value' => 0,
                ),
                array(
                    'timestamp' => 15,
                    'value' => 1,
                ),
            ),
            2 => array(
                array(
                    'timestamp' => 25,
                    'value' => 10,
                ),
            ),
        );

        $series = QueryHandler::toSeries($data);

        $this->assertCount(2, $series);
        $this->assertEquals(1, $series[0]->getId());
        $this->assertCount(2, $series[0]->getMeasurments());
        $this->assertEquals(10, $series[0]->getMeasurments()[0]->getMoment());
        $this->assertEquals(0, $series[0]->getMeasurments()[0]->getValue());
    }

    public function testToSerie_InvalidArrayNotAnArray()
    {
        $this->setExpectedException('InvalidArgumentException');
        QueryHandler::toSeries(array(
            1 => 'notanarray',
        ));
    }

    public function testToSerie_InvalidArrayMissingFields()
    {
        $this->setExpectedException('InvalidArgumentException');
        QueryHandler::toSeries(array(
            1 => array(
                'missing' => 'required fields',
            ),
        ));
    }
}
