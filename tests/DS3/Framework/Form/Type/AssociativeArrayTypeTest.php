<?php

namespace DS3\Framework\Form\Type;

class AssociativeArrayTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testArray()
    {
        $t = new AssociativeArrayType(new StringType(), new DoubleType());
        $this->assertSame(array(
            'foo' => 0.15,
            '1' => 5.0,
        ), $t->transform(array(
            'foo' => '0.15',
            1 => 5,
        )));
        $this->assertNull($t->transform(null));
    }
}
