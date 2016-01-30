<?php

namespace DS3\Framework\Form\Validation;


class NotBlankValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testBlank()
    {
        $ctx = new ValidationContext('');
        $validator = new NotBlankValidator();
        $validator->setValidationContext($ctx);
        $validator->validate('');
        $this->assertEquals('V00002', $ctx->getViolations()[0]->getCode());

        $ctx = new ValidationContext('');
        $validator = new NotBlankValidator();
        $validator->setValidationContext($ctx);
        $validator->validate('     ');
        $this->assertEquals('V00002', $ctx->getViolations()[0]->getCode());

    }

    public function testNotBlank()
    {
        foreach (array(2, 'Foo', new \stdClass()) as $item) {
            $ctx = new ValidationContext('');
            $validator = new NotBlankValidator();
            $validator->setValidationContext($ctx);
            $validator->validate($item);
            $this->assertCount(0, $ctx->getViolations());
        }
    }

    public function testNull()
    {
        $ctx = new ValidationContext('');
        $validator = new NotBlankValidator();
        $validator->setValidationContext($ctx);
        $validator->validate(null);
        $this->assertCount(0, $ctx->getViolations());
    }
}
