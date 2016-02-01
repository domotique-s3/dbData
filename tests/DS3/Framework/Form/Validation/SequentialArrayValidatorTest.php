<?php

namespace DS3\Framework\Form\Validation;

class SequentialArrayValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $ctx = new ValidationContext('');
        $v = new SequentialArrayValidator();
        $v->setValidationContext($ctx);
        $v->validate(null);
        $this->assertCount(0, $ctx->getViolations());
    }

    public function testNotAnArray()
    {
        foreach (array(5, 'notAnArray', new \stdClass()) as $item) {
            $ctx = new ValidationContext('');
            $v = new SequentialArrayValidator();
            $v->setValidationContext($ctx);
            $v->validate($item);
            $this->assertEquals('V00004', $ctx->getViolations()[0]->getCode());
        }
    }

    public function testValidArray()
    {
        $ctx = new ValidationContext('');
        $v = new SequentialArrayValidator(array(new NotNullValidator()));
        $v->setValidationContext($ctx);
        $v->validate(array(1, 2, 3, 4.0, 'five'));
        $this->assertCount(0, $ctx->getViolations());
    }

    public function testInvalidArray()
    {
        $ctx = new ValidationContext('test');
        $v = new SequentialArrayValidator(array(new NotNullValidator()));
        $v->setValidationContext($ctx);
        $v->validate(array(1, 2, null, 4, 5));
        $this->assertEquals('test.2', $ctx->getViolations()[0]->getField());
        $this->assertEquals('V00001', $ctx->getViolations()[0]->getCode());
        $this->assertEquals('value', $ctx->getViolations()[0]->getType());
    }
}
