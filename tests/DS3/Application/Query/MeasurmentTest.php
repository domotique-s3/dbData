<?php

namespace DS3\Application\Query;

class MeasurmentTest extends \PHPUnit_Framework_TestCase
{
	public function testGetterSetter()
	{
		$measur = new Measurment();

		$measur->setMoment(2);
		$measur->setValue(1);
		$this->assertEquals(2, $measur->getMoment());
		$this->assertEquals(1, $measur->getValue());
	}
	

}