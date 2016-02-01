<?php

namespace DS3\Framework\Form\Type;

class SequentialArrayTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $t = new SequentialArrayType(new DoubleType());
        $this->assertSame(
            array(5.0, 2.5, 4.0),
            $t->transform(array('5', '2.5', 4))
        );
        $this->assertNull($t->transform(null));
    }
}
