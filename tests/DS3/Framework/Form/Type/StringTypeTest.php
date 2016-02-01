<?php

namespace DS3\Framework\Form\Type;

class StringTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $t = new StringType();
        $this->assertSame('5', $t->transform(5));
        $this->assertSame('2.7', $t->transform(2.7));
        $this->assertSame('aaa', $t->transform('aaa'));
        $this->assertSame('aaa   ', $t->transform('aaa   '));
        $this->assertNull($t->transform(null));
    }
}
