<?php

namespace DS3\Framework\Form\Validation;


class NotBlankValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testBlank()
    {
        $validator = new NotBlankValidator();
        $this->assertInternalType('string', $validator->validate(''));
        $this->assertInternalType('string', $validator->validate(' '));
    }

    public function testNotBlank()
    {
        $validator = new NotBlankValidator();
        $this->assertNull($validator->validate(2));
        $this->assertNull($validator->validate('Foo'));
        $this->assertNull($validator->validate(new \stdClass()));
    }

    public function testNull()
    {
        $validator = new NotBlankValidator();
        $this->assertNull($validator->validate(null));
    }


}
