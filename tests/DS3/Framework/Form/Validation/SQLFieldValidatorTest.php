<?php

namespace DS3\Framework\Form\Validation;


class SQLFieldValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $ctx = new ValidationContext('');
        $v = new SQLFieldValidator();
        $v->setValidationContext($ctx);
        $v->validate('validAlphaNumeric0123456789_');
        $this->assertCount(0, $ctx->getViolations());
    }

    public function testForbiddenChars()
    {
        $ctx = new ValidationContext('');
        $v = new SQLFieldValidator();
        $v->setValidationContext($ctx);
        $v->validate('h@ckerM4n!');
        $this->assertEquals('V00010', $ctx->getViolations()[0]->getCode());
    }

    public function testNull()
    {
        $ctx = new ValidationContext('');
        $validator = new SQLFieldValidator();
        $validator->setValidationContext($ctx);
        $validator->validate(null);
        $this->assertCount(0, $ctx->getViolations());
    }
}
