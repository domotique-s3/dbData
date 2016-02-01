<?php

namespace DS3\Framework\Form\Validation;

class AssociativeArrayValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $ctx = new ValidationContext('');
        $validator = new AssociativeArrayValidator(array(new NotBlankValidator()), array(new NotBlankValidator()));
        $validator->setValidationContext($ctx);
        $validator->validate(null);
        $this->assertCount(0, $ctx->getViolations());
    }

    public function testNoErrors()
    {
        $data = array(
            'key' => 'value'
        );

        $ctx = new ValidationContext('');
        $validator = new AssociativeArrayValidator(array(new NotBlankValidator()), array(new NotBlankValidator()));
        $validator->setValidationContext($ctx);
        $validator->validate($data);
        $this->assertCount(0, $ctx->getViolations());
    }

    public function testNotAnArray()
    {
        $data = 2;

        $ctx = new ValidationContext('');
        $validator = new AssociativeArrayValidator(array(new NotBlankValidator()), array(new NotBlankValidator()));
        $validator->setValidationContext($ctx);
        $validator->validate($data);
        $this->assertEquals('V00004', $ctx->getViolations()[0]->getCode());
        $this->assertEquals('value', $ctx->getViolations()[0]->getType());
    }

    public function testError()
    {
        $data = array(
            'notSQLField@' => '' // Blank value
        );

        $ctx = new ValidationContext('test');
        $validator = new AssociativeArrayValidator(array(new SQLFieldValidator()), array(new NotBlankValidator()));
        $validator->setValidationContext($ctx);
        $validator->validate($data);

        $this->assertEquals('V00010', $ctx->getViolations()[0]->getCode());
        $this->assertEquals('key', $ctx->getViolations()[0]->getType());
        $this->assertEquals('test.notSQLField@', $ctx->getViolations()[0]->getField());
        $this->assertEquals('V00002', $ctx->getViolations()[1]->getCode());
        $this->assertEquals('value', $ctx->getViolations()[1]->getType());
        $this->assertEquals('test.notSQLField@', $ctx->getViolations()[1]->getField());
    }
}
