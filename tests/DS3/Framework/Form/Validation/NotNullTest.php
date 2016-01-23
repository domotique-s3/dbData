<?php

namespace DS3\Framework\Form\Validation;


class NotNullTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $v = new NotNull();
        $this->assertInternalType('string', $v->validate(null));
    }

    public function testWhateverNotNull()
    {
        $v = new NotNull();
        $this->assertNull($v->validate(''));
        $this->assertNull($v->validate(0.0));
        $this->assertNull($v->validate(array()));
        $this->assertNull($v->validate(new \stdClass()));
    }
}
