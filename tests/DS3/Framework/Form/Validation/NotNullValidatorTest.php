<?php

namespace DS3\Framework\Form\Validation;

class NotNullValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $ctx = new ValidationContext('');
        $v = new NotNullValidator();
        $v->setValidationContext($ctx);
        $v->validate(null);
        $this->assertEquals('V00001', $ctx->getViolations()[0]->getCode());
    }

    public function testWhateverNotNull()
    {
        foreach (array('', 0.0, array(), new \stdClass()) as $item) {
            $ctx = new ValidationContext('');
            $v = new NotNullValidator();
            $v->setValidationContext($ctx);
            $v->validate($item);
            $this->assertCount(0, $ctx->getViolations());
        }
    }
}
