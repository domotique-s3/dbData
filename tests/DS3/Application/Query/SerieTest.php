<?php

namespace DS3\Application\Query;


class SerieTest extends \PHPUnit_Framework_TestCase
{
	$serie = new Serie()

	public function testGetterSetter()
	{
		$serie->setId(2);
		$this->assertEquals(2, $serie->getId());
	}
	

}