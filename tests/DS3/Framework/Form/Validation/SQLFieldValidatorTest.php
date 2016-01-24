<?php

namespace DS3\Framework\Form\Validation;


class SQLFieldValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $v = new SQLFieldValidator();
        $this->assertNull($v->validate('validAlphaNumeric0123456789_'));
    }

    public function testForbiddenChars()
    {
        $v = new SQLFieldValidator();
        $this->assertInternalType('string', $v->validate('h@ckerM4n!'));
    }

    public function testNull()
    {
        $v = new SQLFieldValidator();
        $this->assertNull($v->validate(null));
    }
}
