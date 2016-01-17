<?php

namespace DS3\Application\Query;

class MeasurmentTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $measur = new Measurment(1, 2);

        $this->assertEquals(2, $measur->getTimestamp());
        $this->assertEquals(1, $measur->getValue());
    }
}
