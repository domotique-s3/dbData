<?php

namespace DS3\Framework\Form\Validation;

class GreaterThanValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGreaterThan()
    {
        $ctx = new ValidationContext('');
        $v = new GreaterThanValidator(0);
        $v->setValidationContext($ctx);
        $v->validate(50);
        $this->assertCount(0, $ctx->getViolations());
    }

    public function testLowerThan()
    {
        $ctx = new ValidationContext('');
        $v = new GreaterThanValidator(0);
        $v->setValidationContext($ctx);
        $v->validate(-1);
        $this->assertEquals('V00003', $ctx->getViolations()[0]->getCode());
    }

    public function testEquals()
    {
        $ctx = new ValidationContext('');
        $v = new GreaterThanValidator(5);
        $v->setValidationContext($ctx);
        $v->validate(5);
        $this->assertEquals('V00003', $ctx->getViolations()[0]->getCode());
    }

    public function testNull()
    {
        $ctx = new ValidationContext('');
        $v = new GreaterThanValidator(0);
        $v->setValidationContext($ctx);
        $v->validate(null);
        $this->assertCount(0, $ctx->getViolations());
    }
}
