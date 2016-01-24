<?php

namespace DS3\Framework\Form\Type;

class IntegerTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $t = new IntegerType();
        $this->assertSame(5, $t->transform('5'));
        $this->assertSame(2, $t->transform(2.8));
        $this->assertSame(2, $t->transform(2.1));
        $this->assertNull($t->transform(null));
    }
}
