<?php

namespace DS3\Framework\Form\Validation;


class GreaterThanTest extends \PHPUnit_Framework_TestCase
{
    public function testGreaterThan()
    {
        $v = new GreaterThan(0);
        $this->assertNull($v->validate(50));
    }

    public function testLowerThan()
    {
        $v = new GreaterThan(0);
        $this->assertInternalType('string', $v->validate(-1));
    }

    public function testEquals()
    {
        $v = new GreaterThan(5);
        $this->assertInternalType('string', $v->validate(5));
    }

    public function testNull()
    {
        $v = new GreaterThan(0);
        $this->assertNull($v->validate(null));
    }
}
