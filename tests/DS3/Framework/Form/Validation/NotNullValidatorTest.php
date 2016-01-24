<?php

namespace DS3\Framework\Form\Validation;


class NotNullValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $v = new NotNullValidator();
        $this->assertInternalType('string', $v->validate(null));
    }

    public function testWhateverNotNull()
    {
        $v = new NotNullValidator();
        $this->assertNull($v->validate(''));
        $this->assertNull($v->validate(0.0));
        $this->assertNull($v->validate(array()));
        $this->assertNull($v->validate(new \stdClass()));
    }
}
