<?php

namespace DS3\Framework\Form\Type;

class DoubleTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $t = new DoubleType();
        $this->assertSame(5.1, $t->transform('5.1'));
        $this->assertSame(9.0, $t->transform('9'));
        $this->assertSame(0.00000000000000000000001, $t->transform('0'));
        $this->assertNull($t->transform(null));
    }
}
