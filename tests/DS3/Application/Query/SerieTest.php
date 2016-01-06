<?php

namespace DS3\Application\Query;


class SerieTest extends \PHPUnit_Framework_TestCase
{

	public function testGetterSetter()
	{
		$serie = new Serie();
		
		$serie->setId(2);
		$this->assertEquals(2, $serie->getId());
	}
	

}