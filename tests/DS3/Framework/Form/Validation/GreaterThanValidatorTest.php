<?php

namespace DS3\Framework\Form\Validation;


class GreaterThanValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGreaterThan()
    {
        $v = new GreaterThanValidator(0);
        $this->assertNull($v->validate(50));
    }

    public function testLowerThan()
    {
        $v = new GreaterThanValidator(0);
        $this->assertInternalType('string', $v->validate(-1));
    }

    public function testEquals()
    {
        $v = new GreaterThanValidator(5);
        $this->assertInternalType('string', $v->validate(5));
    }

    public function testNull()
    {
        $v = new GreaterThanValidator(0);
        $this->assertNull($v->validate(null));
    }
}
