<?php

namespace DS3\Application\Query;


class SerieTest extends \PHPUnit_Framework_TestCase
{

	public function testGetterSetter()
	{
		$array = array();
		$array[] = new Measurment(1, 2);

		$serie = new Serie(3, $array);
		
		$this->assertEquals(3, $serie->getId());
		$this->assertEquals(1, $serie->getMeasurments()[0]->getValue());
		$this->assertEquals(2, $serie->getMeasurments()[0]->getMoment());
	}
	

}