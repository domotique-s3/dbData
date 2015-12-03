<?php

namespace DS3\Framework\HTTP;

class ParameterBagTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $pb = new ParameterBag(array('foo' => 'bar'));
        $this->assertEquals('bar', $pb->get('foo'));
    }
}
